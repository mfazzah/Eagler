<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('info.php');
include('db.php');
include('send_message.php');
use \Mailjet\Resources;
if (!isset($_SESSION["user"])){
  header( "Location: http://".$host."/project-gs-eagles-dating-application/eagler/php/login.php?timestamp=7" );
  exit;
}

//checks number of user actions session user has on swipe and changes category to active user if over threshold
function checkThreshold($user_id, $server, $uname, $pass, $dbname){
    $sql = "SELECT (select COUNT(user_id) FROM user_action where user_id =".$user_id.") +
            (select COUNT(user_id) from user_seen where user_id =".$user_id.") +
            (select COUNT(DISTINCT receiving_user) from user_message where sending_user =".$user_id.") 
            AS sum";
    $connection = createConnection($server, $uname, $pass, $dbname);
    $result = $connection->query($sql);

    if($result > "15"){
        $sql = "UPDATE user SET role='active' WHERE user_id= ".$user_id."";
        
        if ($connection->query($sql) === TRUE){ 
        } else {
            echo "Error updating record: ".$connection->error; 
        }
    }
    $connection->close(); 
}

if (isset($_GET["swipe"])){
  if ($_GET["swipe"] == "left") {
    // add the viewed user to the seen table so the current user no longer sees this user
    $sql = "insert into eagler.user_seen(user_id, seen_id) values(".$_SESSION["user_id"].",".$_GET["user"].")";

    $connection = createConnection($server, $uname, $pass, $dbname);

    $result = $connection->query($sql);
    $connection->close();

    //check if user transitions to active user upon action
    $user_id=$_SESSION["user_id"]; 
    checkThreshold($user_id, $server, $uname, $pass, $dbname);

  }
  else {
    //add the swiped user to the user action table
    $connection = createConnection($server, $uname, $pass, $dbname);
    $sql = "insert into eagler.user_action(user_id, liked_id) values(".$_SESSION["user_id"].",".$_GET["user"].")";
    $result = $connection->query($sql);

    // check if the two users have matched with eachother
    $sql = "select * from eagler.user_action where user_id=". $_GET["user"] . " and liked_id=" . $_SESSION["user_id"];
    $data = $connection->query($sql);
    if ($data->num_rows > 0) {
        // for now when there is a user match we display this, but eventually we want to add a new message to the user messages.
        echo "<script>alert('match!!!!');</script>";

        sendMessage($_SESSION['user_id'], $_GET['user'], 'congratuations we matched!', $connection);

        // send a email to the other user to let them know there is a new match
        // find other user emails
        $sql = "select email from eagler.user where user_id=".$_GET['user'];
        $data = $connection->query($sql);
        $user_email = $data->fetch_assoc()["email"];
        
       require '../vendor/autoload.php';
      $mj = new \Mailjet\Client('4e7436f841db41c0555e6d97723e821d','276617d094db5aea31d1ef95dc2983f9',true,['version' => 'v3.1']);
      $body = [
        'Messages' => [
          [
            'From' => [
              'Email' => "cc12954@georgiasouthern.edu",
              'Name' => "Eagler"
            ],
            'To' => [
              [
                'Email' => $user_email,
                'Name' => "User"
              ]
            ],
            'Subject' => "EAGLER:  NEW MATCH",
            'TextPart' => "Congrats! you have a new match in Eagler.",
            'CustomID' => ""
          ]
        ]
      ];
      $response = $mj->post(Resources::$Email, ['body' => $body]);

    }

    $connection->close();

    //check if user transitions to active user
    $user_id=$_SESSION["user_id"]; 
    checkThreshold($user_id, $server, $uname, $pass, $dbname);
  }
  
}


$user = $_SESSION["user"];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Eagler</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href='../css/home.css'>
<link rel="stylesheet" href='../css/main.css'>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>

<?php
include('page_navigation.php');
?>

<div id="content" class="pretty-box">
  <h3>Swipe Right to match, swipe left to skip</h3>
  <!-- <h5>currently, these are the user profile photos for each possible match.</h5> -->



<?php

$connection = createConnection($server, $uname, $pass, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}


$current_user_id = $_SESSION["user_id"];
$current_purpose = $_SESSION["purpose"];

// check if user is into girls or boys
$sql = "select q_1 from eagler.user_survey where user_id=".$current_user_id;

$data = $connection->query($sql);
$data = $data->fetch_assoc()['q_1'];


//build array of user images
if ($data != "both") {
  $sql2 = "select * from eagler.user_image where user_id !=".$current_user_id." and user_id not in (select seen_id from eagler.user_seen where user_id = ".$current_user_id.") and user_id not in (select liked_id from eagler.user_action where user_id = ".$current_user_id.") and user_id in (select user_id from eagler.user where gender = (select q_1 from eagler.user_survey where user_id=".$current_user_id.")order by longitude asc, latitude asc) and user_id in (select user_id from eagler.user_survey where purpose='".$current_purpose."')  limit 1";
}
else {
  //build array of user images
  $sql2 = "select * from eagler.user_image where user_id !=".$current_user_id." and user_id not in (select seen_id from eagler.user_seen where user_id = ".$current_user_id.") and user_id not in (select liked_id from eagler.user_action where user_id = ".$current_user_id.") and user_id in (select user_id from eagler.user where user_id in (select user_id from eagler.user_survey where purpose='".$current_purpose."')order by longitude asc, latitude asc) limit 1";
}

// echo $sql2;

$data2 = $connection->query($sql2);

$photo_array = [];

if ($data2->num_rows > 0) {
  // output data of each row
  while($row = $data2->fetch_assoc()) {
    //echo "<img src=\"../user_images/".$row["filepath"]."\"><br>";
    $str = "
            <div class='row'>
            <div class='column'>
            <form action='home.php?swipe=left&user=".$row["user_id"]."' method='post'>
            <button class='fa fa-close' style='background-color:#FF0000;' <span></span></button>
            </form> `
            </div>
            <div class='column'>
            <img src='../user_images/".$row["filepath"]."' alt='img' style='height:250px; width: 250px;'>
             
            </div>
            <div class='column'>
            <form action='home.php?swipe=right&user=".$row["user_id"]."' method='post'>
            <button class='fa fa-check' style='background-color:#4CAF50;'</button>
            </form>
            </div>";
    echo $str;
    array_push($photo_array, $row["filepath"]);

    // find the user information to display
    $sql = "select * from eagler.user where user_id=".$row["user_id"];
    $data= $connection->query($sql);
    if($data->num_rows > 0) {
      $row = $data->fetch_assoc();
      echo "<div style ='width: 100px; margin-left: 45%; margin-top: 50px;'>".strtoupper($row['fname']).",<br>";
      echo $row['gender']."<br>";
    }

    $sql = "select * from eagler.user_survey where user_id=".$row["user_id"];
    $data= $connection->query($sql);
    if($data->num_rows > 0) {
      $row = $data->fetch_assoc();
      echo "Major: ". strtoupper($row['q_2'])."<br></div>";
    }
  }
} else {
// add better html code to make this pretty
  echo "no more available users, please check back later to swipe on future users!";
}
$connection->close();
?>
</div>
</body>
<?php
include('footer.php');
?>
</html>