<?php
session_start();
if (isset($_SESSION['username'])){

    $Username = $_SESSION['username'];

    $servername = "localhost";
    $rootUser = "id19918980_root";
    $db = "id19918980_loginsignup";
    $rootPassword = "K!5eB>([=X4gv\qM";
// Server and Database connection
// $servername = "localhost";
// $rootUser = "id19918980_root";
// $db = "id19918980_loginsignup";
//'php_project',
// $rootPassword = "K!5eB>([=X4gv\qM";
    // create connection
    $conn = new mysqli($servername, $rootUser, $rootPassword, $db);

    if ($conn -> connect_error)
    {
        die ("connection failed" . $conn -> connect_error);
    }

    echo "Welcome to UserPage! " . $Username;
    echo "</br>Current Time: ";
    echo date('Y-m-d h:i:s',time());
    echo "</br>";
    echo "<form action = 'index.html' method='POST'>";
    echo "<br/><input type = 'submit' value='Logout'></form>";
    
    echo "<h4>New Description: </h4>";
    echo "<form action = 'InsertDescription.php' method='POST'>";
    echo "<input type = 'text' name = 'desc'>";
    echo "<input type = 'hidden' name = 'username' value = '$Username' readonly>";
	echo "<br/><input type = 'submit' value='Submit'>";
    echo "</form>";
    echo "<h3>Your requests are: </h1>";
    $Query = "SELECT * FROM user_description WHERE U_name = '$Username'";
    $result = $conn -> query($Query);

    if ($result -> num_rows > 0)
    {
        $Num = 1;
        while ($Row = $result -> fetch_assoc())
        {
            echo "<h3>" . $Num . ". Description: " . "</h2>";
            echo $Row['description'] . "</br></br>";
           
            $ID = $Row['ID'];
            echo "</br></br>";
            echo "<form action = 'DeleteDescription.php' method='POST'>";
            echo "<input type = 'hidden' name = 'DescriptionID' value = '$ID' />";
            echo "<input type = 'submit' value='Delete'></form>";
            $Num += 1;
            
            // echo "</br></br>";
            // echo "<form action = 'upload.php',method='POST',enctype='multipart/form-data'>";
            // echo "<input type = 'file' name='fileToUpload' id='fileToUpload'>";
            // echo "<input type = 'submit' value='Upload Image' name='submit'></form>";
            
        }
    }
    else
    {
        echo "<h3>No Requests Found</h1>";
    }
    $Query1 = "SELECT * FROM systemuser WHERE username = '$Username'";
    $result1 = $conn -> query($Query1);
    if ($result1 -> num_rows > 0)
    {
        while ($Row1 = $result1 -> fetch_assoc())
        {   
            $Contact = isset($_GET['Contact'])? htmlspecialchars($_GET['Contact']) : '';
            if($Contact) {
                if($Contact =='.NULL.') {
                    echo "empty";
            } else if($Contact =='email') {
                echo "Preferrened Contact Method: " . $Row1["email"]. "";
            } else if($Contact =='Phone_Number') {
                echo "Preferrened Contact Method: " . $Row1["Phone_Number"]. "";
        }
}   else {
}
            echo "<form action >";
            echo "<select name='Contact'>";
            echo "<option value ='.NULL.'>---</option>";
            echo "<option value ='email'>email</option>";
            echo "<option value ='Phone_Number'>Phone_Number</option>";
            echo "</select>";
            echo "<input type = 'submit' value='select'></form>";
            
        }
    }
    else
    {
        echo "<h1>No Requests Found</h1>";
    }
}
else {
    echo "<script language=\"JavaScript\">\r\n";

    echo "alert(\"Please login\");\r\n";

    echo " location.replace(\"index.html\");\r\n";

    echo "</script>";
}

?>

<!--<!DOCTYPE html>-->
<!--<html lang="en">-->
<!--<head>-->
<!--<meta http-equiv="content-type" content="text/html; charset=utf-8">-->
<!--<title> upload image to db demo </title>-->
<!--</head>-->

<!--<body>-->
<!--<form name="form1" method="post" action="upload_image_todb.php" enctype="multipart/form-data">-->
<!--<p><input type="file" name="photo"></p>-->
<!--<p><input type="hidden" name="action" value="add"><input type="submit" name="b1" value="sumbit"></p>-->
<!--</form>-->

<!--</body>-->
<!--</html>-->
<!DOCTYPE html>
<html>
<body>

<form action="upload.php" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>
</body>
</html>

<?php
$url3 = 'uploads/'; //图片所存在的目录

$url0 = '/uploads/'; //图片所存在的目录
$url = "$url0$Username/";
$url1 = "$url0$Username";
$hostdir=dirname(__FILE__).$url; //要读取的文件夹
if(!is_dir("$url3$Username")){//检查文件夹是否存在
    mkdir("uploads/$Username");    //没有就创建一个新文件夹
    }
// $hostdir=dirname(__FILE__).'/uploads/'; //要读取的文件夹

// $url = '/uploads/'; //图片所存在的目录
else
{
}
$filesnames = array_slice(scandir($hostdir),2); //得到所有的文件
// echo $Username;
// echo $url;
//  print_r($filesnames);exit;
//获取也就是扫描文件夹内的文件及文件夹名存入数组 $filesnames

$www = 'https://project2022syk.000webhostapp.com/'; //域名

foreach ($filesnames as $name) {
    $aurl= "<img width='450' height='400' img src='".$www.$url.$name."'>"; //图片
    echo $aurl ; //输出他
}
?>
