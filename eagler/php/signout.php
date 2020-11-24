<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include 'info.php';
if (!isset($_SESSION["user"])){
    header( "Location: http://".$host."/project-gs-eagles-dating-application/eagler/php/login.php?timestamp=7" );
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
<link rel="stylesheet" href='../css/main.css'>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

<?php
include('page_navigation.php');
?>

<div class="container">
<?php
echo "<h3>signed out of account ".$_SESSION["user"]."</h3>";
session_destroy();

?>
</div>

</body>

</html>
