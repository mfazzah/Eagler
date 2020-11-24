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
<link rel="stylesheet" href='../css/report.css'>
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

<div id="content" class="pretty-box">
<?php

	echo "<h3> Hello ". $_SESSION['fname']. " please let us know below if you are experiencing any issues with our program or the other users, and we will do our best to help.</h3>";

?>
<form action='' method='get'>
	<textarea class="form-control" name="report" placeholder="What issues have you experienced?"></textarea>
	<button class='btn btn-primary'>submit</button>
</form>

<?php
	// include files needed to send emails
	

	if(isset($_GET["report"]) and strlen($_GET["report"])) {

		// send email with error message and sent user id to the developer team
		echo "message sent";
		echo "<form id='jsform' action='../testemail.php' method='post'>";
		echo "<input type='hidden' name=message value='".$_GET['report']."'>";
		echo "<input type='hidden' name=to value='cc12954@georgiasouthern.edu'>";
		echo "<input type='hidden' name=from value='".$_SESSION['user_id']."'>";
		echo "<input type='hidden' name=subject value='Reporting Error'>";
		echo "</form>";

	}
?>
</div>



</body>
<script type="text/javascript">
	document.getElementById('jsform').submit();
</script>
<?php
include('footer.php');
?>
</html>