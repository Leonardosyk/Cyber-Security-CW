<?php
session_start();

if (isset($_SESSION['username'])){
    $Username = $_SESSION['username'];

    $servername = "localhost";
    $rootUser = "id19918980_root";
    $db = "id19918980_loginsignup";
    $rootPassword = "K!5eB>([=X4gv\qM";

    // create connection
    $conn = new mysqli($servername, $rootUser, $rootPassword, $db);

    if ($conn -> connect_error)
    {
        die ("connection failed" . $conn -> connect_error);
    }
}
$dir ="uploads/";
$target_dir = "$dir$Username/";
echo $target_dir;
// $target_dir ="uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    // echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    // echo "The file ". htmlspecialchars($target_file). " has been uploaded.";
    // echo "The file ".$target_file. " has been uploaded.";
    echo "<script language=\"JavaScript\">\r\n";
	echo "alert(\"The file has been uploaded\");\r\n";
    echo "location.replace(\"UserPage.php\");\r\n";
    echo "</script>";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>