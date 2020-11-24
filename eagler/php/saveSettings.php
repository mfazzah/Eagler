<?php
session_start();
include('info.php');
include './db.php';

if (!isset($_SESSION["user"])){
  header( "Location: http://".$host."/project-gs-eagles-dating-application/eagler/php/login.php?timestamp=7" );
  exit;
}
$connection = createConnection($server, $uname, $pass, $dbname);

function validateImage(){
  /* Image validation measures were taken from the answer in:
   https://security.stackexchange.com/questions/235/what-steps-should-be-taken-to-validate-user-uploaded-images-within-an-applicatio*/

  // validate image
  $fileinfo = @getimagesize($_FILES["uploadfile"]["tmp_name"]);
  $width = $fileinfo[0];
  $height = $fileinfo[1];


  // check extension to see if it is a valid extension
  $file_extension = pathinfo($_FILES["uploadfile"]["name"], PATHINFO_EXTENSION);
  $allowed_image_extension = array( "png", "jpg", "jpeg");
  if( !in_array($file_extension, $allowed_image_extension)){
    $response = array(
      "message" => "Can only upload .png, .jpg, or .jpeg files"
    );
    header( "Location: http://".$host."/project-gs-eagles-dating-application/eagler/php/settings.php" );
    exit;
  }
  // validate based on size. Max is 2MB
  else if($_FILES["uploadfile"]["size"] > 2000000) {
      $response = array(
        "message" => "Image sizze exceeds 2MB"
      );
  }
  else if($width > "300" || $height > "200") {
      $response = array(
        "message" => "Image dimension should be within 300x200"
      );
  }

}

//checks if no picture was uplaoded. Currently overrides picture
if(!($_FILES["uploadfile"]["error"] == 4)) {
  //call validation function. If image is correct, nothing happens.
  validateImage();

  $filename = $_FILES['uploadfile']['name'];
  $filetmpname = $_FILES['uploadfile']['tmp_name'];
  $folder = '../user_images/';

  // moves their profile image from the browser to a the folder user_images
  move_uploaded_file($filetmpname,$folder.$filename);

  $sql_photo = 'update eagler.user_image
        SET
        filepath = "'.$filename.'"
        WHERE user_id='.$_SESSION["user_id"];

  if ($connection->query($sql_photo) === TRUE) {
  } else {
    echo "Error: " . $sql_photo . "<br>" . $connection->error;
  }
}

#display picture
$update_query = 'update eagler.user_survey
     SET
     q_1 = "'.$_POST['q1'].'",
     q_2 = "'.$_POST['q2'].'",
     q_3 = "'.$_POST['q3'].'",
     q_4 = "'.$_POST['q4'].'",
     q_5 = "'.$_POST['q5'].'",
     q_6 = "'.$_POST['q6'].'",
     q_7 = "'.$_POST['q7'].'",
     q_8 = "'.$_POST['q8'].'",
     q_9 = "'.$_POST['q9'].'",
     q_10 = "'.$_POST['q10'].'",
     purpose = "'.$_POST['q11'].'"
     WHERE user_id='.$_SESSION["user_id"];

 $bool = $connection->query($update_query);
 if ($bool){
   header( "Location: http://".$host."/project-gs-eagles-dating-application/eagler/php/profile.php" );
   exit;
 }
 else {
   $_SESSION['noUpdate'] = 0;
   header( "Location: http://".$host."/project-gs-eagles-dating-application/eagler/php/profile.php" );
   exit;
 }
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<title>Eagler</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href='../css/home.css'>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
</body>

</html>
