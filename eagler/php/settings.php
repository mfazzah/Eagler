<?php
  session_start();
  include('info.php');
  include './db.php';

  if (!isset($_SESSION["user"])){
    header( "Location: http://".$host."/project-gs-eagles-dating-application/eagler/php/login.php?timestamp=7" );
    exit;
  }

  //if validation returns an error display it
  if(!empty($response)){
      echo "<script>alert(".$response["message"].");</script>";
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
  // will use these later
  $preference = $user_data[0];
  $major = $user_data[1];
  $pizza = $user_data[2];
  $annoying = $user_data[3];
  $best = $user_data[4];
  $look4 = $user_data[5];
  $afterSchool = $user_data[6];
  $blondeBr = $user_data[7];
  $read = $user_data[8];
  $party = $user_data[9];
  $use = $user_data[10];

?>

<html>
<head>
  <style>
      .btn {
        background-color: DodgerBlue;
        border: none;
        color: white;
        padding: 12px 16px;
        font-size: 16px;
        cursor: pointer;
      }
      /* Darker background on mouse-over*/
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
  </style>

  <meta charset="UTF-8">
  <title>Eagler</title>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href='../css/home.css'>
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

<div class="container">
<?php
  //name of session
  echo "<h3>Profile of ".$_SESSION["user"]."</h3>";
?>


</div>
<div id="content" class="pretty-box">

  <!-- gonna handle upload here -->
  <form style="margin:0; padding:0;" method="post" action="saveSettings.php" enctype="multipart/form-data">
      <div class="form-group">
        <br/><label>Change Profile Picture</label><br/>
        <canvas style="border: 1px solid black;margin: 12px;" id="image-canvas" width"300" height="300"></canvas>
        <!-- ONLY ALLOWS PNG AND JPEG images NO variations. Validate in server -->
        <input type="file" accept=".png, .jpg, .jpeg" id="fileInput" name="uploadfile"><br/><br/>
        <script type="text/javascript">
        var canvas = document.getElementById('image-canvas');
        var ctx = canvas.getContext('2d');
        // Trigger the imageLoader function when a file has been selected
        var fileInput = document.getElementById('fileInput');
        fileInput.addEventListener('change', imageLoader, false);

        function imageLoader() {
          // clear canvas. is it needed?
          ctx.clearRect(0,0, canvas.width, canvas.height);

          var reader = new FileReader();
          reader.onload = function(event) {
              img = new Image();
              img.onload = function(){
                  debugger;
                  ctx.drawImage(img,0,0, 300 , 300);
              }
              img.src = reader.result;
          }
          reader.readAsDataURL(fileInput.files[0]);
        }
        </script>
      </div>

      <div class="form-group">
        <label>Purpose: </label></br>
        <input type="radio" id="Romantic" name="q11" value="Romantic" required>
        <label for="Romantic">Romantic</label>
        <input type="radio" id="Social" name="q11" value="Social" required>
        <label for="Social">Social</label>
        <input type="radio" id="Academic" name="q11" value="Academic" required>
        <label for="Academic">Academic</label>
        <br/><br/>

      <div class="form-group">
        <label>Preference: </label></br>
        <input type="radio" id="male" name="q1" value="male" required>
        <label for="boys">Boys</label>
        <input type="radio" id="female" name="q1" value="female" required>
        <label for="girls">Girls</label>
        <input type="radio" id="both" name="q1" value="both" required>
        <label for="both">Both</label>
        <br/><br/>

      <div class="form-group">
        <label for="q2">Please select your major</label><br/>
        <select id="majors" name="q2" required>
          <option disabled selected value> -- Select an option -- </option>
          <option value="accounting">Accounting</option>
          <option value="art">Art</option>
          <option value="biology">Biology</option>
          <option value="compScience">Computer Science</option>
          <option value="engineering">Engineering</option>
          <option value="geography">Geography</option>
          <option value="iTech">Information Technology</option>
        </select>
    </div><br/>

      <div class="form-group">
          <label for="q3">Do you like Pizza?</label><br/>
          <input type="radio" id="duh" name="q3" value="duh" required>
          <label for="duh">Duh</label>
          <input type="radio" id="weird" name="q3" value="weird" required>
          <label for="no">I'm weird</label>
      </div><br/>

      <div class="form-group">
          <label for="q4">The most annoying sound is</label><br/>
          <select id="annoying" name="q4" required>
            <option disabled selected value> -- Select an option -- </option>
            <option value="4.1">Fingernails on a chalkboard</option>
            <option value="4.2">Your parents' disco soundtrack</option>
            <option value="4.3">Busy signal on the phone</option>
            <option value="4.4">The school buzzer</option>
          </select>
      </div></br>
      <div class="form-group">
          <label for="q5">The best thing you have going is:</label><br/>
          <select id="bestThing" name="q5"  required>
            <option disabled selected value> -- Select an option -- </option>
            <option value="5.1">Incredible intelligence</option>
            <option value="5.2">Gut splitting  humor</option>
            <option value="5.3">Amazing honesty</option>
            <option value="5.4">Super looks</option>
            <option value="5.5">Compassionate caring</option>
            <option value="5.6">Exceptional enthusiasm</option>
          </select>
      </div><br/>
      <div class="form-group">
        <label for="q6">What do you look for first in others?</label><br/>
        <select id="lookFor" name="q6" required>
          <option disabled selected value> -- Select an option -- </option>
          <option value="6.1">Doesn't matter</option>
          <option value="6.2">Intelligence</option>
          <option value="6.3">Sense of humor</option>
          <option value="6.4">Honesty</option>
          <option value="6.5">Looks</option>
          <option value="6.6">Caring</option>
          <option value="6.7">Enthusiasm</option>
        </select>
      </div><br/>
      <div class="form-group">
        <label for="q7">After school you usually:</label><br/>
        <select id="afterSchool" name="q7" required>
          <option disabled selected value> -- Select an option -- </option>
          <option value="7.1">Work</option>
          <option value="7.2">Sleep</option>
          <option value="7.3">Study</option>
          <option value="7.4">Shop</option>
          <option value="7.5">Hang out</option>
        </select>
      </div><br/>
      <div class="form-group">
          <label for="q8">Do you like blondes or brunettes?</label><br/>
          <input type="radio" id="blondes" name="q8" value="blondes" required>
          <label for="duh">blondes</label>
          <input type="radio" id="brunettes" name="q8" value="brunettes" required>
          <label for="no">brunettes</label>
      </div><br/>
      <div class="form-group">
          <label for="q9">Do you like to read?</label><br/>
          <input type="radio" id="readYes" name="q9" value="yes" required>
          <label for="duh">yes</label>
          <input type="radio" id="readNo" name="q9" value="no" required>
          <label for="no">no</label>
      </div><br/>
      <div class="form-group">
          <label for="q10">Do you like to party?</label><br/>
          <input type="radio" id="partyYes" name="q10" value="yes" required>
          <label for="duh">yes</label>
          <input type="radio" id="partyNo" name="q10" value="no" required>
          <label for="no">no</label>
      </div><br/>

    </div><br/>
    <input type="submit" id='save' name="save" value="Save"  class="btn"/>
    <input type="button" value="Cancel" onclick="msg()" class="btnCan">
  </form>
</div>

  <script>
    function msg() {
      window.location.replace("profile.php");
    }
  </script>

<script type="text/javascript">

  // automatically select old answers
    var preference = <?php echo json_encode($preference);?>;
    var major = <?php echo json_encode($major);?>;
    var pizza = <?php echo json_encode($pizza);?>;
    var annoying = <?php echo json_encode($annoying);?>;
    var best = <?php echo json_encode($best);?>;
    var look4 = <?php echo json_encode($look4);?>;
    var afterSchool = <?php echo json_encode($afterSchool);?>;
    var blondeBr = <?php echo json_encode($blondeBr);?>;
    var read = <?php echo json_encode($read);?>;
    var party = <?php echo json_encode($party);?>;
    var purpose = <?php echo json_encode($use);?>;

    document.getElementById(preference).checked= true;
    document.getElementById("majors").value = major;
    document.getElementById(pizza).checked= true;
    document.getElementById("annoying").value = annoying;
    document.getElementById("bestThing").value = best;
    document.getElementById("lookFor").value = look4;
    document.getElementById("afterSchool").value = afterSchool;
    document.getElementById(blondeBr).checked= true;
    if (read.localeCompare("yes"))
      document.getElementById("readYes").checked= true;
    else
      document.getElementById("readNo").checked= true;

    if (party.localeCompare("yes"))
      document.getElementById("partyYes").checked= true;
    else
      document.getElementById("partyNo").checked= true;

    if (purpose.localeCompare("Academic"))
      document.getElementById("Academic").checked = true;
    else if (purpose.localeCompare("Social"))
      document.getElementById("Social").checked = true;
    else
      document.getElementById("Romantic").checked = true;



  </script>




  </form>
  <?php
  include('footer.php');
  ?>
</body>

</html>
