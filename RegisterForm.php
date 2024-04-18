<?php

if (isset($_POST['email'])){
    $email = $_POST['email'];
    echo "<form action = 'registerFormCheck.php' method = 'POST'>";

    echo "<h1> Please enter your details below: </h1>";

    echo "<pre>";

    echo "Type in your <strong>Forename</strong>: ";
    echo "			<input name = 'txtForename' type = 'text' />";

    echo "<br/>Type in your <strong>Surname</strong>: ";
    echo "			<input name = 'txtSurname' type = 'text' />";

    echo "<br/>Type in your <strong>Username</strong>: ";
    echo "			<input name = 'txtUsername' type = 'text' />";

    // echo "<br/>Type in your <strong>Email Address</strong>: ";
    // echo "		<input name = 'txtEmail1' type = 'text' />";
    echo "<br/>Your <strong>Email Address</strong>: ";
    echo "			<input name = 'txtEmail1' type = 'text' value = $email readonly>";
    // echo "<br/>Type in your <strong>Email Address again</strong>: ";
    // echo "	<input name = 'txtEmail2' type = 'text' />";

    echo "<h4>The password should be longer than 8 characters <br/> And contain both NUMBERS, UPPERCASE and LOWERCASE letters!</h4>";
    echo "<br/>Type in your <strong>Password</strong>: ";
    echo "			<input name = 'txtPassword1' type = 'password' />";

    echo "<br/>Type in your <strong>Password again</strong>: ";
    echo "		<input name = 'txtPassword2' type = 'password' />";

    echo "<br/>Type in your <strong>Telephone Number</strong>: ";
    echo "	<input name = 'PhoneNumber' type = 'text' />";

    echo "<br/>Type in your <strong>ContactPreference(in detail) </strong>: ";
    echo "	<input name = 'ContactPreference' type = 'text' />";
    // echo "<br/> Contact Preference: ";
    // echo "         <select name='ContactPreference'>";
    // echo "<option name='---' value=''>----------</>";
    // echo "<option name='ContactPreference' >Email</>";
    // echo "<option name='ContactPreference'>PhoneNumber</>";
    // echo "</select>";
    echo "</pre>";

    echo "<br/><input type = 'submit' value = 'Register'>";
    echo "</form>";

    echo "<br /><br />Already Registered? Click <a href = 'index.html'>HERE</a> to login in!";
}
else{
    echo "<script language=\"JavaScript\">\r\n";

    echo " location.replace(\"index.html\");\r\n";

    echo "</script>";
}

?>