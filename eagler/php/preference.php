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
    .btnCan {
      background-color: #ff3333;
      border: none;
      color: white;
      padding: 7px 10px;
      font-size: : 16px;
      cursor: pointer;
      border-radius: 4px;
    }
    .btnCan:hover{
      background-color: coral;
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
    .slidecontainer {
      width: 60%;
    }
    .slider {
      -webkit-appearance: none;
      appearance: none;
      width: 100%;
      height: 25px;
      border-radius: 15px;
      background: #d3d3d3;
      outline: none;
      opacity: 0.7;
      -webkit-transition: .2s;
      transition: opacity .2s;
    }
    .slider:hover {
      opacity: 1;
    }
    .slider::-webkit-slider-thumb {
      -webkit-appearance: none; /* Override default look */
      appearance: none;
      width: 25px; /* Set a specific slider handle width */
      height: 25px; /* Slider handle height */
      border-radius: 50%; /* Makes slider icon round*/
      background: #4CAF50; /* Green background */
      cursor: pointer; /* Cursor on hover */
    }
    .settings {
      font-weight: 900;
    }
    .ui-slider .ui-slider-handle{
      width: 50%;
    }
    .slider-range {
      width: 25px;
      height: 25px;
    }

  </style>
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <!-- slider stuff -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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

  <div id="content" class="pretty-box">
    <script>
      $( function() {
        $( "#slider-range" ).slider({
          range: true,
          min: 18,
          max: 55,
          values: [ 18, 25 ],
          slide: function( event, ui ) {
            $( "#amount" ).val(ui.values[ 0 ] + " - " + ui.values[ 1 ] );
          }
        });
        $( "#amount" ).val( $( "#slider-range" ).slider( "values", 0 ) +
          " - " + $( "#slider-range" ).slider( "values", 1 ) );
      } );
      </script>
      <p><br/>
    <label style="font-weight: 900;">Age:</label>
    <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
  </p>

  <div id="slider-range"></div>
  </br>
  <!--label style="font-weight: 900;" id="lAge">Age: (php to set pref)</label>
      <div class="slidecontainer">
          <input type="range" min="18" max="100" value="21" class="slider" id="age">
      </div>
  </br></br-->
  <label style="font-weight: 900;" id="lDist">Distance: (php to set pref)</label>
      <div class="slidecontainer">
          <input type="range" min="0" max="100" value="25" class="slider" id="dist">
      </div>
  </br></br>
  <form name="radios">
    <label style="font-weight: 900;" id="lCampus">Campus: (php to set pref)</label></br>
    <input type="radio" name="campus" value="Armstrong" checked>
      <label>Armstrong</label>
    <input type="radio" name="campus" value="Statesboro">
      <label>Statesboro</label>
    <input type="radio" name="campus" value="Liberty">
      <label>Liberty</label>
  </form>
</br></br>
  <input type="submit" id='save' name="save" onclick="msg()" value="Save"  class="btn"/>
  <input type="button" value="Cancel" onclick="msg()" class="btnCan">

  </div>

  <script type="text/javascript">
      // var sliderAge = document.getElementById("age");
      // var outputAge = document.getElementById("lAge");
      // outputAge.innerHTML = "Age: " + sliderAge.value;
      // sliderAge.oninput = function() {
      //     outputAge.innerHTML = "Age: " + this.value;
      // }

      var sliderMiles = document.getElementById("dist");
      var outputDist = document.getElementById("lDist");
      outputDist.innerHTML = "Distance: " + sliderMiles.value + " miles";
      sliderMiles.oninput = function() {
          outputDist.innerHTML = "Distance: " + this.value + " miles";
      }

      var campus = document.radios.campus;
      var lcampus = document.getElementById("lCampus");
      lcampus.innerHTML = "Campus: " + campus[0].value;
      for(var i = 0; i < campus.length; i++){
          campus[i].addEventListener('change', function(){
            lcampus.innerHTML = "Campus: " + this.value;
          });
      }
      function msg() {
        window.location.replace("profile.php");
      }

  </script>

<?php
include('footer.php');
?>
</body>
</html>
