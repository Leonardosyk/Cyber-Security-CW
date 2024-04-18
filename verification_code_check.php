<?php session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'] . '/mail/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/SMTP.php';

//require './mail/Exception.php';
//require './mail/PHPMailer.php';
//require './mail/SMTP.php';

// Server and Database connection
// $servername = "localhost";
// $rootUser = "id19918980_root";
// $db = "id19918980_loginsignup";
//'php_project',
// $rootPassword = "K!5eB>([=X4gv\qM";

$mysql_host = "localhost";
$mysql_database = "id19918980_loginsignup";
$mysql_user = "id19918980_root";
$mysql_password = "K!5eB>([=X4gv\qM";

// Connect to the server
$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die ("Fail to connect to the server");


if (isset($_POST['code'])) {
    
	function testPassword($password) {

		$result = 0;
		$length = strlen($password);
	
		if ($length == 0 ){
	
			return 1;
		}
	
		else {
			if((strtolower($password) == $password) or (strtoupper($password) == $password)){
				$result = 2;
		    }
			if($length < 8){
				$result = 3;
		    }
			if (ctype_digit($password) or ctype_alpha($password)){
				$result = 4;
		    }
		}
	
		return $result;
	}

	$user_email = '';
	$hashed_code = '';
	#The user's email
	$user_email = $_SESSION['email'];
	#The hashed verification code stored in SSESION, even if a malicious user tries to steal the code, he will not get the code directly
	$hashed_code = $_SESSION["num"];
	#The verification code entered by the user
	$code = htmlspecialchars($_POST["code"]);

	#Obtain user information to prevent malicious programs from stealing identity information
	if (md5($_SERVER['HTTP_USER_AGENT']) != $_SESSION['HTTP_USER_AGENT']) {   
		echo "<script language=\"JavaScript\">\r\n";

		echo " alert(\"User identity invalid! Please retry\");\r\n";

		echo " location.replace(\"verification_code.php\");\r\n";

		echo "</script>";
		exit;
	}

	#Get new password
	$new_password1 = $_POST["new_password1"];
	$new_password2 = $_POST["new_password2"];
	session_destroy();

	#verify if the new password matches
	if ($new_password1 != $new_password2) {
		echo "<script language=\"JavaScript\">\r\n";

		echo " alert(\"The new password does not match! Please retry\");\r\n";

		echo " location.replace(\"verification_code.php\");\r\n";

		echo "</script>";

		exit;
	}

	$pw_result = testPassword($new_password1);

	if ($pw_result == 1) {

		echo "<script language=\"JavaScript\">\r\n";

		echo "alert(\"The password cannot be empty!!\");\r\n";

		echo "window.location.href='verification_code.php'";

		echo "</script>";
	}

	if ($pw_result == 2) {

		echo "<script language=\"JavaScript\">\r\n";

		echo "alert(\"The password must contain both uppercase and lowercase letters!\");\r\n";

		echo "window.location.href='verification_code.php'";

		echo "</script>";
	}

	if ($pw_result == 3) {

		echo "<script language=\"JavaScript\">\r\n";

		echo "alert(\"The password must be longer than 8 characters!\");\r\n";

		echo "window.location.href='verification_code.php'";

		echo "</script>";

	}

	if ($pw_result == 4) {

    echo "<script language=\"JavaScript\">\r\n";

    echo "alert(\"The password cannot be pure numbers or letters!\");\r\n";

	echo "window.location.href='verification_code.php'";

    echo "</script>";

	}

	#Verify if the two verification code matches
	if (password_verify($code,$hashed_code)) {

		//change the password in database

		$hashed_new_pw = password_hash($new_password1, PASSWORD_BCRYPT);

		$stmt = $connection->prepare("UPDATE systemuser SET Password = ? WHERE Email = ?");
		$stmt->bind_param("ss", $hashed_new_pw, $user_email);

		$stmt->execute();

		echo "<script language=\"JavaScript\">\r\n";

		echo "alert(\"Code Verified! The password has been reset. Redirecting to login page\");\r\n";

		echo "window.location.href='.html'";
				
		echo "</script>";

	}
	else {
		echo "<script language=\"JavaScript\">\r\n";

		echo "alert(\"Wrong Code! Redirecting to the previous page...\");\r\n";

		echo "window.location.href='verification_code.php'";
				
		echo "</script>";
	}
	
}

else {
    
    if(isset($_POST['submit'])){  

        if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) { 
    
            $secretKey   = "6LeIJjojAAAAAHjHFjRl9yEirJb2D-XOkvKToV0z";
            $responseKey = $_POST['g-recaptcha-response'];
            $userIP      = $_SERVER['REMOTE_ADDR'];
            $url         = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
            $response    = file_get_contents($url);
            $response    = json_decode($response);
        
            if($response->success){
    
            	$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
            	$email = $_POST['email'];
            	$SANITIZED_email = filter_var($email, FILTER_SANITIZE_EMAIL);
            
            	// Check if the email already exists in the database
            	$userResult = $connection -> query("SELECT Email FROM systemuser");
            	$found_email = 0;
            	
            	while ($userRow = mysqli_fetch_array($userResult)) {
            	    
            		//Check if the email entered matches with any value in the database
            		if ($userRow['Email'] == $SANITIZED_email) {
            		    
            			$found_email = 1;
            			$num = rand(10000000,99999999);
            
            			#encrypt the verification code
            			$hashed_code = password_hash($num, PASSWORD_BCRYPT);
            			$_SESSION["num"] = $hashed_code;
            			$_SESSION["email"] = $email;
            
                        $mail = new PHPMailer;
                        $mail->CharSet ="UTF-8";                     //设定邮件编码
                        $mail->SMTPDebug = 0;                        // 调试模式输出
                        $mail->isSMTP();                             // 使用SMTP
                        $mail->Host = 'smtp.gmail.com';                // SMTP服务器
                        $mail->SMTPAuth = true;                      // 允许 SMTP 认证
                        $mail->Username = 'ykshan52@gmail.com';                // SMTP 用户名  即邮箱的用户名
                        $mail->Password = 'v z q a z l g s b g o x b c l p';             // SMTP 密码  部分邮箱是授权码(例如163邮箱)
                        $mail->SMTPSecure = 'ssl';                    // 允许 TLS 或者ssl协议
                        $mail->Port = 465;                            // 服务器端口 25 或者465 具体要看邮箱服务器支持
                    
                        $mail->setFrom('ykshan52@gmail.com', 'Administrator');  //发件人
                        $mail->addAddress($email, 'Dear User');  // 收件人
                        //$mail->addAddress('ellen@example.com');  // 可添加多个收件人
                        $mail->addReplyTo('ykshan52@gmail.com', 'info'); //回复的时候回复给哪个邮箱 建议和发件人一致
                        //$mail->addCC('cc@example.com');                    //抄送
                        //$mail->addBCC('bcc@example.com');                    //密送
            
                        //Content
                        $mail->isHTML(true);                                  // 是否以HTML文档格式发送
                        $mail->Subject = "Verification Code For Password Recovery";
                        $mail->Body = $num. '<br/><br/>' . date('Y-m-d H:i:s');
            			if ($mail->send()) {
            				echo "<script language=\"JavaScript\">\r\n";
            
            				echo " alert(\"Verification Code Sent!\");\r\n";
            				
            				echo "</script>";
            				
            				echo "<form method='post' action='verification_code_check.php'>";
              				echo "Code: ";
            				echo "<input name='code' type='text' /><br />";
            				echo "<h4>The password should be longer than 8 characters <br/> And contain both NUMBERS, UPPERCASE and LOWERCASE letters!</h4>";
            				echo "<br/>New password: ";
            				echo "<input name='new_password1' type='password' /><br />";
            				echo "<br/>New password again: ";
            				echo "<input name='new_password2' type='password' /><br />";
              				echo "<br/><input type='submit' />";
              				echo "</form>";
            			}
            			else {
            				
            				echo "<script language=\"JavaScript\">\r\n";
            
            				echo " alert(\"Error: Fail to send verification code! Please retry\");\r\n";
            
            				echo " location.replace(\"verification_code.php\");\r\n";
            
            				echo "</script>";
            
            				exit;
            			}
            		}
            	}
            	
            	if ($found_email == 0) {
            		
            		echo "<script language=\"JavaScript\">\r\n";
            
            		echo " alert(\"Email Address Not Found! Please retry\");\r\n";
            
            		echo " location.replace(\"verification_code.php\");\r\n";
            
            		echo "</script>";
            		
            	}
            }
        }
        
        else {
        echo "<script language=\"JavaScript\">\r\n";
    
        echo " alert(\"Verification failed\");\r\n";
    
        echo " location.replace(\"email_verify.php\");\r\n";
    
        echo "</script>";
        }
    }
}
?>