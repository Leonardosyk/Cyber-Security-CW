<?php
session_start();
//session_start();
//session_destroy();
// Server and Database connection
// $servername = "localhost";
// $rootUser = "id19918980_root";
// $db = "id19918980_loginsignup";
//'php_project',
// $rootPassword = "K!5eB>([=X4gv\qM";

//$servername = "localhost";
//$rootUser = "root";
//$db = "php_project";
//$rootPassword = "";

$servername = "localhost";
$rootUser = "id19918980_root";
$db = "id19918980_loginsignup";
$rootPassword = "K!5eB>([=X4gv\qM";

// create connection
$conn = new mysqli($servername, $rootUser, $rootPassword, $db);

// values come from user, through webform
$username = htmlspecialchars($_POST['txtUsername']);
$password = $_POST["txtPassword"];

// check connection
if ($conn -> connect_error)
{
	die ("connection failed" . $conn -> connect_error);
}

// Query
$userQuery = "SELECT * FROM systemuser";
$userResult = $conn -> query($userQuery);

// flag variable
$userFound = 0;

// echo "<table border = '1'>";
	if ($userResult -> num_rows > 0)
	{
		while ($userRow = $userResult -> fetch_assoc())
		{
			if ($userRow['username'] == $username)
			{
				$userFound = 1;
					if (password_verify( $password,$userRow['password']))
					{
						$_SESSION['username'] = $username;
						if ($userRow['IsAdmin'] == 1){
							header('location:AdminPage.php');
						}
						else {
						    header('location:UserPage.php');
						    
    				// 		echo "<script language=\"JavaScript\">\r\n";
    
    				// 		echo "alert(\"1!\");\r\n";
    
    				// 		echo "location.replace(\"UsePage.php\");\r\n";
    
    				// 		echo "</script>";
						}
					}
					else
					{
						echo "<script language=\"JavaScript\">\r\n";

						echo "alert(\"Wrong password!\");\r\n";

						echo "location.replace(\"index.html\");\r\n";

						echo "</script>";
					}
			}
		}
	}
	echo "</table>";
	
	if ($userFound == 0)
	{
		echo "Unknown user!";
	}
// session_destroy();
?>