<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand">Eagler</a>
    </div>
    <ul class="nav navbar-nav">
      
      <?php
        if (isset($_SESSION['admin'])) {
          echo "<li><a href='./admin.php'>Admin</a></li>";
          echo "<li><a href='./signout.php'>Sign Out</a></li>";
        }
        else {
          echo "<li><a href='./home.php'>Home</a></li>";
          echo "<li><a href='./profile.php'>Profile</a></li>";
          echo "<li><a href='./messages.php'>Messaging</a></li>";
          echo "<li><a href='report.php'>Report Issue</a></li>";
          echo "<li><a href='./signout.php'>Sign Out</a></li>";
        }
      ?>
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