<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// this will keep track of login attempts
if (!isset($_SESSION["limit"]))
    $_SESSION["limit"] = 0;

if (!isset($_SESSION["attemptEmail"]))
    $_SESSION["attemptEmail"] = $_POST["email"];


$email = $_POST["email"];
$password = $_POST["pword"];
$latitude = $_POST["latitude"];
$longitude = $_POST["longitude"];

include './db.php';
include './info.php';

// connect to the db
$connection = createConnection($server, $uname, $pass, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$data = $connection->query("select * from eagler.user");

$fname = '';
$lname = '';
$user_id = '';

$signin = false;
if ($data->num_rows > 0) {
    // output data of each row
    while($row = $data->fetch_assoc()) {
        if ($email == $row["email"] and password_verify($password, $row["user_password"])) {
            // assign values in session for current user
            $fname = $row["fname"];
            $lname = $row["lname"];
            $user_id = $row["user_id"];

            $signin = true;

            if ($row['admin'] == 1) {
                $_SESSION['admin'] = 1;
            }
        }
    }
} else {
}


if (!$signin) {
    $_SESSION["error"] = 0;
    if (strcmp($_SESSION["attemptEmail"],$_POST["email"]) == 0)
      $_SESSION["limit"] += 1;
    else {
      $_SESSION["limit"] = 0;
      $_SESSION["attemptEmail"] = $_POST["email"];
    }
    header("Location: http://".$host."/project-gs-eagles-dating-application/eagler/php/home.php?timestamp=7 ");
    exit;
}
else {
    $_SESSION["user"] = $email;
    $_SESSION["fname"] = $fname;
    $_SESSION["lname"] = $lname;
    $_SESSION["user_id"] = $user_id;

    // find the user purpose
    $sql = "select purpose from eagler.user_survey where user_id=".$user_id;
    $data = $connection->query($sql);
    $data = $data->fetch_assoc()["purpose"];
     $_SESSION["purpose"] = $data;

    if (isset($_SESSION['admin'])) {
        header("Location: http://".$host."/project-gs-eagles-dating-application/eagler/php/admin.php?timestamp=7 ");
    }
    else {

        header("Location: http://".$host."/project-gs-eagles-dating-application/eagler/php/home.php?timestamp=7 ");
        
        //update geolocation now that session has been verified 
        $sql = "UPDATE user SET latitude = $latitude, longitude = $longitude WHERE user_id = $user_id";
        if($connection->query($sql) === TRUE) {
            echo "record updated";
        } else {
            echo "error updating". $connection->error; 
        }
    }



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
<h1>success you logged in !!!!</h1>
</body>

</html>
