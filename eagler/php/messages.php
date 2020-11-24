<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('info.php');
include('db.php');
include('send_message.php');
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
<link rel="stylesheet" href='../css/message.css'>
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
  echo "<h3>Messages for ".$_SESSION["fname"]."</h3>";
?>

<?php
// sql to build a list of users that the current user has a message with
$sql = "select distinct least(sending_user, receiving_user) as value1, greatest(sending_user, receiving_user) as value2 from eagler.user_message where sending_user = ".
	$_SESSION['user_id']." or receiving_user=".$_SESSION['user_id'];

$connection = createConnection($server, $uname, $pass, $dbname);
$data = $connection->query($sql);
    if ($data->num_rows > 0) {
        // output data of each row
	    while($row = $data->fetch_assoc()) {
	        if ($row["value1"]==$_SESSION['user_id']){
	        	$other_id = $row['value2'];
	        	$sql = "select * from eagler.user where user_id ='".$other_id."'";
	        	$data2 = $connection->query($sql);
	        	if ($data2->num_rows>0){
	        		
	        		while ($hello = $data2->fetch_assoc()) {
	        			echo "<div id='user'><a href='./messager.php?user=".$hello['user_id']."' >".$hello['fname']. ' ' . $hello['lname'].'</a></div>';
	        		}
	        	}
	        }
	        else {
	    		$other_id = $row['value1'];
	        	$sql = "select * from eagler.user where user_id ='".$other_id."'";
	        	$data2 = $connection->query($sql);
	        	if ($data2->num_rows>0){
	        		
	        		while ($hello = $data2->fetch_assoc()) {
	        			echo "<div id='user'><a href='./messager.php?user=".$hello['user_id']."' >".$hello['fname']. ' ' . $hello['lname'].'</a></div>';
	        		}
	        	}
	    	}
	    } 	
     }
     else {
		echo "<div id='user'><p>You currently have no matches.</p></div><br>";
     }
if (isset($_GET['message'])) {
	$connection = createConnection($server, $uname, $pass, $dbname);
	sendMessage($_SESSION['user_id'], $_GET['user'], $_GET['message'], $connection);
}

if (isset($_GET['user'])) {

	// find the other users name to display in messages
	$other_userz = '';
	$sql1 = "select fname from user where user_id=".$_GET['user'];

	$data3 = $connection->query($sql1);
	$other_userz = $data3->fetch_assoc()['fname'];

	//create a query for all the messages in the chat
	$sql = "select * from eagler.user_message where sending_user = ".$_SESSION['user_id']." and receiving_user = ".$_GET['user']." or receiving_user= ".$_SESSION['user_id']." and sending_user = ".$_GET['user'];

	$data2 = $connection->query($sql);
	if ($data2->num_rows>0) {
		echo "<div id='chatArea' style='border: 3px solid #73AD21;'><p>You currently have no matches.</p><br>";
		while($row=$data2->fetch_assoc()) {
			if ($row['sending_user'] == $_SESSION['user_id']) {
				echo "you: ".$row['content'].'<br>';
			}
			else {
				echo $other_userz.': '.$row['content'].'<br>';
			}
			
		}
	}
	// create an input to send more messages
	echo "</div>";
	echo "<form action='messages.php' method='get'>";
    echo "<input name='message'/>";
    echo "<input type='hidden' value=".$_GET['user']." name='user'> </input>";
    echo "<button> send </button";
    echo "</form>";

}

?>
</div>
</body>
<?php
include('footer.php');
?>
</html>
