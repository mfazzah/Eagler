<?php
  session_start();
  include('info.php');
  include('db.php');

  $connection = createConnection($server, $uname, $pass, $dbname);

  //delete both from user_action
  $sql = "DELETE FROM eagler.user_action WHERE user_id=".$_SESSION["user_id"];
  if ($connection->query($sql) === TRUE) {
  } else {
        echo "Error deleting record: " . $connection->error;
  }

  $sql = "DELETE FROM eagler.user_action WHERE liked_id=".$_SESSION["user_id"];
  if ($connection->query($sql) === TRUE) {
  } else {
        echo "Error deleting record: " . $connection->error;
  }

  $sql = "DELETE FROM eagler.user_survey WHERE user_id=".$_SESSION["user_id"];
  if ($connection->query($sql) === TRUE) {
  } else {
        echo "Error deleting record: " . $connection->error;
  }

  // both from user_seen
  $sql = "DELETE FROM eagler.user_seen WHERE user_id=".$_SESSION["user_id"];
  if ($connection->query($sql) === TRUE) {
  } else {
        echo "Error deleting record: " . $connection->error;
  }

  $sql = "DELETE FROM eagler.user_seen WHERE seen_id=".$_SESSION["user_id"];
  if ($connection->query($sql) === TRUE) {
  } else {
        echo "Error deleting record: " . $connection->error;
  }

  $sql = "DELETE FROM eagler.user_image WHERE user_id=".$_SESSION["user_id"];
  if ($connection->query($sql) === TRUE) {
  } else {
        echo "Error deleting record: " . $connection->error;
  }

  // delete messages
  $sql = "DELETE FROM eagler.user_message WHERE sending_user=".$_SESSION["user_id"];
  if ($connection->query($sql) === TRUE) {
  } else {
        echo "Error deleting record: " . $connection->error;
  }

  $sql = "DELETE FROM eagler.user_message WHERE receiving_user=".$_SESSION["user_id"];
  if ($connection->query($sql) === TRUE) {
  } else {
        echo "Error deleting record: " . $connection->error;
  }

  // can finally delete user
  $sql = "DELETE FROM eagler.user WHERE user_id=".$_SESSION["user_id"];
  if ($connection->query($sql) === TRUE) {
  } else {
        echo "Error deleting record: " . $connection->error;
  }


  session_destroy();

  header( "Location: http://".$host."/project-gs-eagles-dating-application/eagler/php/login.php" );


 ?>
