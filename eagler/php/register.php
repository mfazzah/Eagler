<?php
  session_start();
  if(!(isset($_SESSION['site_path_var'])))
      $_SESSION['site_path_var'] = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';

  //if validation returns an error display it
  if(!empty($response))
      echo "<script>alert(".$response["message"].");</script>";

?>


<html>
<head>
<meta charset="UTF-8">
<title>Sign Up</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href='../css/signup.css'>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <h1>Register Page</h1>

    <form action='signup.php' method='post' enctype="multipart/form-data">
        <div class="form-group">
          <label for="exampleInputEmail1">First Name</label>
          <input name="fname" class="form-control" placeholder="Enter First Name" required>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Last Name</label>
            <input name="lname" class="form-control" placeholder="Enter Last Name" required>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Eagle ID</label>
            <input name="username" class="form-control" placeholder="Enter Eagle ID" required
              pattern="\d{9}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Phone Number</label>
            <input type="tel" name="phone_num" class="form-control" placeholder="Enter 10 Digit Phone #" required
              pattern="(\d{3}-{1}\d{3}-{1}\d{4})|([0-9]{3}[0-9]{3}[0-9]{4})" title="888-888-8888">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Gender</label><br/>
            <input name="gender" type="radio" id="male" value="male" required>
            <label for="boys">Male</label>
            <input name="gender" type="radio" id="female" value="female" required>
            <label for="girls">Female</label>

        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Email address</label>
          <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" required>
          <small id="emailHelp" class="form-text text-muted">Make sure to use your georgiasouthern.edu email address or login will not work.</small>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input type="password" name="pword" required class="form-control" id="exampleInputPassword1" placeholder="EnterPassword"
          pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
        </div>
        <div class="form-group">
          <label>Profile Image</label>
          <!-- NEED TO VALIDATE IMAGE FILE IN SERVER -->
          <input type="file" name="uploadfile" accept=".png, .jpg, .jpeg" required>
        </div>
        <?php
          if(isset($_SESSION['inUse'])){
        ?>
        <label style="color:red;">This e-mail is already in use</label><br/>
        <?php
            unset($_SESSION['inUse']);
          }
          elseif (isset($_SESSION['notStudent'])) {
        ?>
        <label style="color:red;">Not a valid e-mail</label><br/>
        <?php
            unset($_SESSION['notStudent']);
          }
        ?>
        <button type="submit" class="btn btn-primary">Register</button>
      </form>
      <div class="sign">
        <form action="login.php">
            <input class="btn btn-primary" type="submit" value="Log in" />
            <small>Already a user? Log in!</small>
        </form>
      </div>


</body>

</html>
