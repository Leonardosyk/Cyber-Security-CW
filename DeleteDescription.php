<?php
$ID = $_POST['DescriptionID'];

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

$sql = $conn->prepare("DELETE FROM user_description WHERE ID = ?");
$sql->bind_param("s", $ID);

if ($sql->execute()){
	echo "<script language=\"JavaScript\">\r\n";

    echo "alert(\"Delete Successful!\");\r\n";

    echo " location.replace(\"UserPage.php\");\r\n";

    echo "</script>";
}
else {
	echo "<script language=\"JavaScript\">\r\n";

    echo "alert(\"Deletion Failed!\");\r\n";

    echo " location.replace(\"UserPage.php\");\r\n";

    echo "</script>";
}

?>