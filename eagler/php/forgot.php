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

    <form action='recoveryEmail.php' method='post' enctype="multipart/form-data">
       
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Email address</label>
          <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" required>
          <small id="emailHelp" class="form-text text-muted">Make sure to use your georgiasouthern.edu email address or login will not work.</small>
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
        <button type="submit" class="btn btn-primary">Send Recovery Email.</button>
      </form>
      


</body>

</html>
