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
<link rel="stylesheet" href='../css/main.css'>
<link rel="stylesheet" href='../css/message.css'>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
    
    .container {

      border: 2px solid #dedede;
      background-color: #f1f1f1;
      border-radius: 5px;
      padding: 10px;
      margin: 10px 0;
      width: 100%;
    }
    
    .darker {
      border-color: #ccc;
      background-color: #ddd;
    }

    .cole {
      margin-right: 10%;
    }
    
    .container::after {
      content: "";
      clear: both;
      display: table;
    }

    .time-right {
      float: right;
      color: #aaa;
    }
    
    .time-left {
      float: left;
      color: #999;
    }
</style>

</head>
<body>
<?php
include('page_navigation.php');
?>
<div id="content" class="pretty-box">
<?php
$sql = "select distinct least(sending_user, receiving_user) as value1, greatest(sending_user, receiving_user) as value2 from eagler.user_message where sending_user = ".
$_SESSION['user_id']." or receiving_user=".$_SESSION['user_id'];

$connection = createConnection($server, $uname, $pass, $dbname);


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
		while($row=$data2->fetch_assoc()) {
			if ($row['sending_user'] == $_SESSION['user_id']) {
				echo "<div class= 'container cole'><p>you: ".htmlspecialchars($row['content'])."</p><span class= 'time-right'>".$row['sent_date']."</span></div>";
			}
			else {
                echo "<div class= 'container darker'><p>";
                echo $other_userz.': '.htmlspecialchars($row['content'])."</p><span class= 'time-left'>".$row['sent_date']."</span></div>";
			}
			
		}
	}
	// create an input to send more messages

    echo "<form action='messager.php'>";
    echo "<label for='message'>Message:</label>";
    echo "<input name='message'/ style='width:60%'>";
    echo "<input type='hidden' value=".$_GET['user']." name='user'> </input>";
    echo "<button> send </button>";
    echo "</form>";

}
?>
</div>
</body>
<?php
include('footer.php');
?>
</html>
