<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('info.php');
include('db.php');
$connection = createConnection($server, $uname, $pass, $dbname);
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

		echo "<h3>Eagler statistics</h3>";

		$sql = "select count(*) as t from eagler.user";
		$result = $connection->query($sql);
		$result = $result->fetch_assoc();
		$result = $result['t'];

		echo "<div>total users: ".$result."</div>";

		$sql = "select count(*) as t from eagler.user_message";
		$result = $connection->query($sql);
		$result = $result->fetch_assoc();
		$result = $result['t'];

		echo "<div>total messages sent: ".$result."</div>";

		$sql = "select (SELECT count(*) FROM user_action a1 INNER JOIN user_action a2 ON a2.liked_id = a1.user_id and a1.liked_id = a2.user_id)/(select 2) as t;
";
		$result = $connection->query($sql);
		$result = $result->fetch_assoc();
		$result = $result['t'];

		echo "<div>total matches: ".$result."</div>";

		echo "<h3>User Managment</h3>";
		echo "<div>Please enter in the user you wish to delete</div>";
	?>

	<form action='' method='post'>
	<input name="userDelete" placeholder="enter user_id">
	<br>
	<button class="btn" type='submit'>submit</button>
</form>

<br>
<h3>User Information</h3>
<div>Please enter in the user youd wish to get info for</div>
<form action='' method='post'>
	<input name="userInfo" placeholder="enter user_id">
	<br>
	<button class="btn" type='submit'>submit</button>
</form>


<br>
<?php
	if (isset($_POST['userInfo'])){
		$sql = "select * from eagler.user where user_id=".$_POST['userInfo'];
		$data = $connection->query($sql);
		$data = $data->fetch_assoc();
		echo "<textarea style='width:100%; height:100px;'>";
		echo "First Name: ". $data['fname']. "\n";
		echo "Last Name: ". $data['lname']. "\n";
		echo "Email: ". $data['email']. "\n";
		echo "</textarea>";
	}
?>
<?php
	if (isset($_POST['userDelete'])) {
		echo "<script>alert('deleted')</script>";

		$sql = "SET FOREIGN_KEY_CHECKS=0";
		if ($connection->query($sql) === TRUE) {
		} else {
			    echo "Error deleting record: " . $connection->error;
		}

		$sql = "DELETE FROM eagler.user_action WHERE user_id=".$_POST['userDelete'];
		if ($connection->query($sql) === TRUE) {
		} else {
			    echo "Error deleting record: " . $connection->error;
		}

		$sql = "DELETE FROM eagler.user_survey WHERE user_id=".$_POST['userDelete'];
		if ($connection->query($sql) === TRUE) {
		} else {
			    echo "Error deleting record: " . $connection->error;
		}

		$sql = "DELETE FROM eagler.user_seen WHERE user_id=".$_POST['userDelete'];
		if ($connection->query($sql) === TRUE) {
		} else {
			    echo "Error deleting record: " . $connection->error;
		}

		$sql = "DELETE FROM eagler.user_image WHERE user_id=".$_POST['userDelete'];
		if ($connection->query($sql) === TRUE) {
		} else {
			    echo "Error deleting record: " . $connection->error;
		}

		$sql = "DELETE FROM eagler.user WHERE user_id=".$_POST['userDelete'];
		if ($connection->query($sql) === TRUE) {
		} else {
			    echo "Error deleting record: " . $connection->error;
		}
	}
?>

<h3>
	User Messaging Search
</h3>
<div>Please enter in the user_id whose messages you would like to view</div>
<form action='' method='post'>
	<input name="userMessage" placeholder="enter user_id">
	<br>
	<button class="btn" type='submit'>submit</button>
</form>
<br>
<?php
	if (isset($_POST['userMessage'])) {

		$sql = "select * FROM eagler.user_message WHERE receiving_user=".$_POST['userMessage']." or sending_user=". $_POST['userMessage'];
		$data = $connection->query($sql);
		echo "<textarea style='width:100%; height:200px;'>";
		if ($data->num_rows > 0) {
			while($row = $data->fetch_assoc()) {
				echo "from user_id=".$row['sending_user']. " to user_id=".$row['receiving_user']." message: ".$row['content']."\n";
			}
		}	
		echo "</textarea>";
	}
?>
</div>
</body>
<?php
include('footer.php');
?>
</html>