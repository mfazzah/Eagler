<?php
session_start();
echo '<h1> Registration Quiz for '. (isset($_GET["email"])? $_GET["email"] : "No e-mail") . '</h1>';
$_SESSION["user"] = $_GET["email"];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Quiz</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href='../css/quiz.css'>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<!-- questions taken from: https://matchomatics.com/index.php?country=usa&page=questionnaires&type=1-->
<form action='../php/quiz_upload.php?' method='post'>
        <div class="form-group">
          <label for="q1">Do you like boys or girls</label><br/>
          <input type="radio" id="male" name="q1" value="male" required>
          <label for="boys">Boys</label>
          <input type="radio" id="female" name="q1" value="female" required>
          <label for="girls">Girls</label>
          <input type="radio" id="both" name="q1" value="both" required>
          <label for="both">Both</label>
        </div><br/>
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
            <label for="q11">What would you like to use Eagler for?</label><br/>
            <select id="majors" name="q11" required>
              <option disabled selected value> -- Select an option -- </option>
              <option value="Romantic">Romantic</option>
              <option value="Academic">Academic</option>
              <option value="Social">Social</option>
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
            <input type="radio" id="duh" name="q8" value="blondes" required>
            <label for="duh">blondes</label>
            <input type="radio" id="weird" name="q8" value="brunettes" required>
            <label for="no">brunettes</label>
        </div><br/>
        <div class="form-group">
            <label for="q9">Do you like to read?</label><br/>
            <input type="radio" id="duh" name="q9" value="yes" required>
            <label for="duh">yes</label>
            <input type="radio" id="weird" name="q9" value="no" required>
            <label for="no">no</label>
        </div><br/>
        <div class="form-group">
            <label for="q10">do you like to party?</label><br/>
            <input type="radio" id="duh" name="q10" value="yes" required>
            <label for="duh">yes</label>
            <input type="radio" id="weird" name="q10" value="no" required>
            <label for="no">no</label>
        </div><br/>
        <button type="submit" class="btn btn-primary">Register</button>
</form>
</body>
</html>
