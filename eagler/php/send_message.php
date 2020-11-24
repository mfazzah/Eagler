<?php
function sendMessage($from, $to, $content, $conn) {
	if(empty($content)){
	}
	else{
		$date = date("Y-m-d h:i:sa");
		$sql = "insert into eagler.user_message(sending_user, receiving_user, sent_date, content) values(".$from.",".$to.",'".$date."','".$content."')";
	//add user to db
		if ($conn->query($sql) === TRUE) {
		} 	else {
	    	echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
}

?>