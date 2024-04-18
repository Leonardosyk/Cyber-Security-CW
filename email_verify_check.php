<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'] . '/mail/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/SMTP.php';

//require './mail/Exception.php';
//require './mail/PHPMailer.php';
//require './mail/SMTP.php';

if (isset($_POST['user_code'])){
    $email = $_POST['email'];
    $user_code = htmlspecialchars($_POST['user_code']);
    $v_code = htmlspecialchars($_POST['v_code']);
    if ($user_code == $v_code){

        echo "<form method='post' action='RegisterForm.php'>";

        echo "Correct Code! Please continue...";

        echo "<input name = 'email' type = 'hidden' value =$email readonly><br />";

        echo "<br/><br/><input type = 'submit' value = 'continue'>";
        echo "</form>";

    }
    else {
        echo "Wrong Verification Code! Please retry...<br/>";
        echo "<form method='post' action='email_verify_check.php'>";

        echo "<br/>Email: ";
        echo "<input name = 'email' type = 'text' value =$email readonly><br />";

        echo "<br/>Code: ";
        echo "<input name='user_code' type='text' /><br />";

        echo "<input name = 'v_code' type = 'hidden' value =$v_code readonly>";
        //echo "<br/>$v_code<br>";
        echo "<br/><input type='submit' value = 'retry'/>";
        echo "</form>";
    }
}

else {
    if(isset($_POST['submit'])){  
		$email = $_POST['email'];
		// Check to make sure that email address contains @
		if (strpos ($email, "@") == false)
		{
			echo "<script language=\"JavaScript\">\r\n";
	
			echo " alert(\"The email address is not valid!\");\r\n";
	
			echo " location.replace(\"email_verify.php\");\r\n";
	
			echo "</script>";
		}
	
		// Check to make sure email address has the right format
		$SANITIZED_email = filter_var($email, FILTER_SANITIZE_EMAIL);
		if (!filter_var($SANITIZED_email, FILTER_VALIDATE_EMAIL))
		{
			echo "<script language=\"JavaScript\">\r\n";
	
			echo " alert(\"Unvalid Email Format!\");\r\n";
	
			echo " location.replace(\"email_verify.php\");\r\n";
	
			echo "</script>";
		}
	
	    $mysql_host = "localhost";
		$mysql_database = "id19918980_loginsignup";
		$mysql_user = "id19918980_root";
		$mysql_password = "K!5eB>([=X4gv\qM";
		
		// Connect to the server
		$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die ("Fail to connect to the server");
	
		$userResult = $connection -> query ("SELECT * FROM systemuser");
		// Loop through from the first to the last record
		while ($userRow = mysqli_fetch_array($userResult))
		{
			//Check if the email entered matches with any value in the database
			if ($userRow['email'] == $email)
			{
				echo "<script language=\"JavaScript\">\r\n";
	
				echo " alert(\"The email address has already been used!\");\r\n";
	
				echo " location.replace(\"email_verify.php\");\r\n";
	
				echo "</script>";
				
				exit;
				
			}
		}
		
		$v_code = rand(10000000,99999999);
		
		$mail = new PHPMailer;
		$mail->CharSet ="UTF-8";                     //设定邮件编码
		$mail->SMTPDebug = 0;                        // 调试模式输出
		$mail->isSMTP();                             // 使用SMTP
		$mail->Host = 'smtp.gmail.com';                // SMTP服务器
		$mail->SMTPAuth = true;                      // 允许 SMTP 认证
		$mail->Username = 'ykshan52@gmail.com';                // SMTP 用户名  即邮箱的用户名
		$mail->Password = 'v z q a z l g s b g o x b c l p';             //  SMTP 密码  部分邮箱是授权码(例如163邮箱)
		$mail->SMTPSecure = 'ssl';                    // 允许 TLS 或者ssl协议
		$mail->Port = 465;                            // 服务器端口 25 或者465 具体要看邮箱服务器支持
	
		$mail->setFrom('ykshan52@gmail.com', 'Administrator');  //发件人
		$mail->addAddress($email, 'Dear User');  // 收件人
		//$mail->addAddress('ellen@example.com');  // 可添加多个收件人
		$mail->addReplyTo('ykshan52@gmail.com', 'info'); //回复的时候回复给哪个邮箱 建议和发件人一致
		//$mail->addCC('cc@example.com');                    //抄送
		//$mail->addBCC('bcc@example.com');                    //密送
	
		//发送附件
		// $mail->addAttachment('../xy.zip');         // 添加附件
		// $mail->addAttachment('../thumb-1.jpg', 'new.jpg');    // 发送附件并且重命名
	
		//Content
		$mail->isHTML(true);                                  // 是否以HTML文档格式发送
		//$mail->Subject = "Verification Code For Lovejoy's Antique Store Registration";
		$mail->Subject = "Verification Code For Registration";
		$mail->Body = 'The code is: ' . $v_code. '<br/><br/>' . date('Y-m-d H:i:s');
		
		if ($mail->send()) {
			echo "<script language=\"JavaScript\">\r\n";
	
			echo " alert(\"Verification Code Sent!\");\r\n";
			
			echo "</script>";
			
			echo "<form method='post' action='email_verify_check.php'>";
	
			echo "Email: ";
			
			echo "<input name = 'email' type = 'text' value =$email readonly><br />";
	
			echo "<br/>Code: ";
			
			echo "<input name='user_code' type='text' /><br />";
	
			echo "<input name = 'v_code' type = 'hidden' value =$v_code readonly>";

			echo "<br/><input type='submit' />";
			
			echo "</form>";
		}
	}
	
        else {
        echo "<script language=\"JavaScript\">\r\n";
    
        echo " alert(\"Verification failed\");\r\n";
    
        echo " location.replace(\"email_verify.php\");\r\n";
    
        echo "</script>";
        }
    }
?>