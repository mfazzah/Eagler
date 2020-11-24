<?php
session_start();

// grab user email from session variable
$user_email = $_SESSION["user"];

// connect to database and insert quiz results
include './db.php';
include './info.php';

$connection = createConnection($server, $uname, $pass, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
// find the current user user_id so you can add quiz values
$sql1 = 'select user_id from eagler.user where email="' . $user_email . '"';
$data = $connection->query($sql1);
$data = $data->fetch_array();
$user_id = $data[0];

$sql2 = 'insert into eagler.user_survey(user_id,q_1,q_2,q_3,q_4,q_5,q_6,q_7,q_8,q_9,q_10) values ("'.
    $user_id . '","'. $_POST["q1"] . '","' . $_POST["q2"] .'","'. $_POST["q3"] . '","' . $_POST["q4"] .
    '","' . $_POST["q5"] . '","' . $_POST["q6"] . '","' . $_POST["q7"] . '","' . $_POST["q8"] .
    '","' . $_POST["q9"] . '","' .$_POST["q10"] . '")';

// insert user_survey record into db
if ($connection->query($sql2) === TRUE) {
} else {
    echo "Error: " . $sql2 . "<br>" . $connection->error;
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Sign up</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href='../css/login.css'>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
<div class="container">
    <div class="jumbotron">
        <h1>Eagler</h1>
    </div>
</div>
<div class='data'>
    <h2>Congratulations!</h2>
    <p>You submitted your quiz successfully. Please see below to sign in to your user profile and get to swiping!!!</p>
    <form action="login.php">
        <button type="submit" class="btn btn-primary">Log In</button>
    </form>
</div>
</body>

</html>
