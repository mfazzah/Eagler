<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Eagler</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="./php/home.php">Home</a></li>
      <li><a href="./php/profile.php">Profile</a></li>
      <li><a href="./php/messages.php">Messaging</a></li>
      <li><a href="./php/signout.php">Sign Out</a></li>
      <li><a href="./php/report.php">Report Issue</a></li>
    </ul>
  </div>
</nav>
<script>
window.onscroll = function() {myFunction()};

var navbar = document.getElementById("navbar navbar-default");
var sticky = navbar.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}
</script>