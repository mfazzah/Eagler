<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Eagler</title>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href='../css/login.css'>
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <!--Geolocation -->
  <script>
<!--Geolocation -->
<script>
  function getLocation(){
    if(navigator.geolocation){
      navigator.geolocation.getCurrentPosition(
        function success(position){  
          document.getElementById("latitude"). value = position.coords.latitude; 
          document.getElementById("longitude").value = position.coords.longitude;
        },
      function error(errorMessage) {
        //error occurs, use approximate coordinates instead
        console.error('An error has occured while retrieving location: ', errorMessage);
        ipLookup();
      }
      );
    } else {
      //geolocation not supported/enabled, use IP lookup for approximate location
      console.log('Geolocation not enabled on browser')
      ipLookup()

    }
  }
//gets approximate lat/lon coordinates based on IP address
  function ipLookup(){
    $.ajax('http://ip-api.com/json')
    .then(
      function success(response) {
        document.getElementById("latitude"). value = response.lat; 
        document.getElementById("longitude").value = response.lon;
      },
      function fail(data, status){
        console.log('Request failed. Returned status of ', status);
      }
    );
  }

  </script>
</head>

<body onload="getLocation()">
    <div class="container">
        <div class="jumbotron">
          <h1>Eagler</h1>
        </div>
    </div>
    <form action='signin.php' onsubmit="return verify();" method='post'>
        <div class="form-group">
          <label for="exampleInputEmail1">Email address</label>
          <input id="email" type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
          <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input type="password" name="pword" class="form-control" id="exampleInputPassword1" placeholder="Password">
        </div>
        <!-- this is to indicate if there is a wrong email or password -->
        <?php
          if (isset($_SESSION["error"])) {
        ?>
        <label style='color:red;'>Incorrect e-mail or password</label><br/>
        <?php
          unset($_SESSION['error']);
        }
         ?>
         <!-- hidden inputs for geolocation -->
         <input id="longitude" name="longitude" type="hidden">
         <input id="latitude" name="latitude" type="hidden">
        <button type="submit" class="btn btn-primary">Log in</button>
      </form>
      <form action="register.php" class="register">
        <input class="btn btn-primary" name="signup" type="submit" value="Register"/>
        <small id="emailHelp" class="form-text text-muted">Dont have an account yet? Register.</small>
    </form> <br>
    <form action="forgot.php" class="forgot">
    <input class="btn btn-primary" name="forgot" type="submit" value="Forgot Password?"/>
    <small id="emailHelp" class="form-text text-muted">You will need your account email.</small>
    </form>
</body>

</html>
