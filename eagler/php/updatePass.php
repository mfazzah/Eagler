<?php
session_start();
echo '<h1> Password Reset for '. (isset($_GET["email"])? $_GET["email"] : "No e-mail") . '</h1>';
$_SESSION["user"] = $_GET["email"];

?>



<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Quiz</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href='../css/quiz.css'>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<!-- questions taken from: https://matchomatics.com/index.php?country=usa&page=questionnaires&type=1-->
<form action='../php/pass_upload.php' method='post'>
        <div class="form-group">
          <label for="exampleInputPassword1"> New Password</label>
          <input type="password" name="q1" class="form-control" id="exampleInputPassword1">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
</form>
</body>

</html>
