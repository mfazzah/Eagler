<?php
  session_start();
  include('info.php');
  include './db.php';

  if (!isset($_SESSION["user"])){
    header( "Location: http://".$host."/project-gs-eagles-dating-application/eagler/php/login.php?timestamp=7" );
    exit;
  }

  if (isset($_SESSION["noUpdate"])){
    echo "<script>alert('Could not update information. Try again later.')</script>";
    unset($_SESSION["noUpdate"]);
  }

  #display picture
  $connection = createConnection($server, $uname, $pass, $dbname);
  $sql_picture_name = "select filepath from eagler.user_image where user_id=\"".$_SESSION["user_id"]."\"";
  $user_data = $connection->query($sql_picture_name);
  $user_data = $user_data->fetch_array();
  $image_name = "../user_images/".$user_data[0]; //should return only the filepath

  $survey_query = "Select * from eagler.user_survey WHERE user_id=\"".$_SESSION["user_id"]."\"";
  $user_data = $connection->query($survey_query);
  $user_data = $user_data->fetch_array();
  $preference = $user_data[0];
  $major = $user_data[1];

?>


<html>
<head>

  <meta charset="UTF-8">
  <title>Eagler</title>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href='../css/home.css'>
  <link rel="stylesheet" href='../css/main.css'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    .btn {
      background-color: DodgerBlue;
    }
    /* Darker background on mouse-over */
    .btn:hover {
      background-color: RoyalBlue;
    }
    div.info {
      display: inline-block;
      width: 500px
    }

    label.settings {
      font-weight: 900;
      display:block;
      width: 50;
    }
    label {
      font-size: 20px;
      text-transform: capitalize;
      font-weight: 200;
    }
    form {
      margin:0;
      padding:0;
      text-align:left;
      display: inline;
    }
    .del {
      background-color: red;
    }
    .del:hover {
      background-color: white;
    }
  </style>
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
    //name of session
    echo "<h3>Profile of ".$_SESSION["user"]."</h3>";

    //settings
  ?>

</div>

  <!-- I played with the idea of changing everything in the profile.php page
  without having to create a settings.php page and stuff. I will pursue it at a
  later time -->
  <div id="content" class="pretty-box">
      <!--contains a canvas that will house the image -->
      <div id="settings">
        <img id="profile" style="display: none;" src=<?=$image_name?> />
        <canvas style="border: 1px solid black;margin: 12px;" id="image-canvas" width"300" height="300"></canvas>
        <script type="text/javascript">
            /* you still load the image using the img tag but you hide it.
             once hidden you place it inside the canvas object so it will fit
             the dimmensions without being elongated */
            var drawing = document.getElementById("image-canvas");
            var con = drawing.getContext("2d");
            var image = document.getElementById("profile");
            /* without this, you need to refresh the page for the image
              to pop up. This will check if the image has been loaded, and
              when it has it will automatically draw it on canvas to avoid
              any refreshing */
            image.onload = function() {
              con.drawImage(image, 0, 0, 300, 300);
            }
        </script>
      </div>

      <div class="info">
        <form action="settings.php" method="post">
          <button style="float: right;" type="submit" style="width:80px;height:70px;"
          class="btn"><i class="fa fa-gear"></i></button>
        </form>
        <label class="settings">Name: </label>
            <label><?=$_SESSION["fname"]." ".$_SESSION['lname']?></label></br>
        <label class="settings">Preference: </label>
            <label> <?=$preference ?></label></br>
        <form action="preference.php" method="post">
            <button style="float:right" class="btn" type="submit"><i class="fa fa-wrench">
                  Preferences</i></button>
            </form>
        <label class="settings">Major: </label>
            <label><?=$major?></label></br></br>


        <form action="delete.php" method="post" onsubmit="return check();">
            <button style="float:right" class="del" type="submit"><i class="fa fa-user-times">
              Delete Account</i></button>
        </form>
      </div>
    </div>
    <script type="text/javascript">
        function check(){
          return confirm("Are you sure you want to delete your account?");
        }
    </script>
<?php
include('footer.php');
?>
</body>
</html>
