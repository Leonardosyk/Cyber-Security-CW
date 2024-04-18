<?php
$username = $_POST['username'];

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
$connection = new mysqli($servername, $rootUser, $rootPassword, $db);
if ($connection -> connect_error)
{
	die ("connection failed" . $conn -> connect_error);
}


$Request = filter_var(mysqli_real_escape_string($connection, $_POST['desc']), FILTER_SANITIZE_STRIPPED);

$sql = $connection->prepare("INSERT INTO user_description (U_name, description) VALUES (?, ?)");
$sql->bind_param("ss", $username, $Request);

if ($sql->execute()){
    echo "<script language=\"JavaScript\">\r\n";

    echo "alert(\"Add new description Successful!\");\r\n";

    echo " location.replace(\"UserPage.php\");\r\n";

    echo "</script>";
}
else {
    echo "<script language=\"JavaScript\">\r\n";

    echo "alert(\"Add new description fail!\");\r\n";

    echo " location.replace(\"UserPage.php\");\r\n";

    echo "</script>";
}


?>