<?php

function testPassword($password){

    $result = 0;
    $length = strlen($password);

    if((strtolower($password) == $password) or (strtoupper($password) == $password)){
        $result = 2;

    }

    if($length < 8){
        $result = 3;

    }

    if (ctype_digit($password) or ctype_alpha($password)){
        $result = 4;
            
    }

    return $result;
}

$mysql_host = "localhost";
$mysql_database = "id19918980_loginsignup";
$mysql_user = "id19918980_root";
$mysql_password = "K!5eB>([=X4gv\qM";

// Connect to the server
$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die ("Fail to connect to the server");

// Copy all of the data from the form into variables
$forename = $_POST['txtForename'];
$surname = $_POST['txtSurname'];
$username = $_POST['txtUsername'];
$email1 = $_POST['txtEmail1'];
//$email2 = $_POST['txtEmail2'];
$password1 = $_POST['txtPassword1'];
$password2 = $_POST['txtPassword2'];
$phone_num = $_POST['PhoneNumber'];
$preference = $_POST['ContactPreference'];
// Create a variable to indicate if any error has occurred or not, 0 = False and 1 = True
$errorOccurred = 0;

// Make sure that all text boxes were not blank
if ($forename == "")	
{
	echo "Forename was blank!<br/>";
	$errorOccurred = 1;
}

if ($surname == "")
{
	echo "Surname was blank!<br/>";
	$errorOccurred = 1;
}

if ($username == "")
{
	echo "username was blank!<br/>";
	$errorOccurred = 1;
}

// if ($email1 == "" or $email2 == "")
// {
// 	echo "Email not provided!<br/>";
// 	$errorOccurred = 1;
// }

if ($password1 == "" or $password2 == "")
{
	echo "Password not provided!<br/>";
	$errorOccurred = 1;
}

if ($password1 != $password2)
{
	echo "Passwords do not match!<br/>";
	$errorOccurred = 1;
}

if (!is_numeric($phone_num))
{
	echo "Phone number should be a series of digits!<br/>";
	$errorOccurred = 1;
}

$pw_result = testPassword($password1);

	if ($pw_result == 2){

		echo "<script language=\"JavaScript\">\r\n";

		echo "alert(\"The password must contain both uppercase and lowercase letters! Please retry\");\r\n";

		echo "window.location.href='RegisterForm.php'";

		echo "</script>";
	}

	if ($pw_result == 3) {

		echo "<script language=\"JavaScript\">\r\n";

		echo "alert(\"The password must be longer than 8 characters! Please retry\");\r\n";

		echo "window.location.href='RegisterForm.php'";

		echo "</script>";

	}

	if ($pw_result == 4) {

    echo "<script language=\"JavaScript\">\r\n";

    echo "alert(\"The password cannot be pure numbers or letters! Please retry\");\r\n";

	echo "window.location.href='RegisterForm.php'";

    echo "</script>";

	}

// Check if username already exists in the database
$userResult = $connection -> query ("SELECT * FROM systemuser");
// $userRow = mysqli_fetch_array($userResult);
// echo $userRow['Username'];
// Loop through from the first to the last record
while ($userRow = mysqli_fetch_array($userResult))
{
	//Check if current user's username matches the one from the database
	if ($userRow['username'] == $username)
	{
		echo "The username has already been used! <br/>";
		$errorOccurred = 1;
	}
}

// Check if the email already exists in the database
$userResult = $connection -> query("SELECT * FROM systemuser");

// Loop through from the first to the last record
while ($userRow = mysqli_fetch_array($userResult))
{
	//Check if the email entered matches with any value in the database
	if ($userRow['email'] == $email1)
	{
		echo "The email address has already been used! <br/>";
		$errorOccurred = 1;
	}
}

// // Check to make sure that email address contains @
// if (strpos ($email1, "@") == false or strpos ($email2, "@") == false)
// {
// 	echo "The email address is not valid!<br/>";
// 	$errorOccurred = 1;
// }

// // Check to make sure the two emails match
// if ($email1 != $email2)
// {
// 	echo "Emails do not match";
// 	$errorOccurred = 1;
// }

// // Check to make sure email address has the right format
// $SANITIZED_email = filter_var($email1, FILTER_SANITIZE_EMAIL);
// if (!filter_var($SANITIZED_email, FILTER_VALIDATE_EMAIL))
// {
// 	echo "Unvalid Email Format!";
// 	$errorOccurred = 1;
// }

// prepare and bind
$stmt = $connection->prepare("INSERT INTO systemuser (username, password, forename, surname, email, Phone_Number,Preference) VALUES (?, ?, ?, ?, ?, ?,?)");
$stmt->bind_param("sssssss", $username_es, $hashed_password, $forename_es, $surname_es, $email_es, $phone_num_es, $preference_es);
// Check to see if an error has occured, if not, then add the details to the database
if ($errorOccurred == 0)
{
	#special chars process
	$sc_forename = htmlspecialchars($_POST['txtForename']);
	$sc_surname = htmlspecialchars($_POST['txtSurname']);
	$sc_username = htmlspecialchars($_POST['txtUsername']);
	$sc_password = htmlspecialchars($_POST['txtPassword1']);
	$sc_phone_num = htmlspecialchars($_POST['PhoneNumber']);
    $sc_preference = $_POST['ContactPreference'];
	#encrypt password
	$hashed_password = password_hash($sc_password, PASSWORD_BCRYPT);

	#Escaping mechanisms
	$forename_es = mysqli_real_escape_string($connection,$sc_forename);
	$surname_es = mysqli_real_escape_string($connection,$sc_surname);
	$username_es = mysqli_real_escape_string($connection,$sc_username);
	$email_es = mysqli_real_escape_string($connection,$email1);
	$phone_num_es = mysqli_real_escape_string($connection,$sc_phone_num);
	$preference_es = mysqli_real_escape_string($connection,$sc_preference);
	$stmt->execute();

	// $sql = "INSERT INTO SystemUser (Username, Password, Forename, Surname, Email)
	// 	VALUES ('$username_es', '$hashed_password', '$forename_es', '$surname_es', '$email_es')";
	
	// successfully registered
	echo "Hello " . $sc_forename . " '" . $sc_username ."' ". $sc_surname ."<br />";
	echo "Thank you for becoming a member of us!";

	echo "<br /><br />Click <a href = 'index.html'>HERE</a> to login in!";
	
}

?>