<!--
this is nav bar for vote and candidate users 
for guest is below this one
-->
<?php include 'config/config.php';?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo '/wevote/candidates.php'; ?>">WeVote</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor02">
      <ul class="navbar-nav ms-auto">
        <!--This item for candidate users only-->
        <li class="nav-item">
          <a class="nav-link" href="#">View My Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/wevote/<?php echo BASE_URL; ?>">Candidates List</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/wevote/wvow">Leaderboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Program critize</a>
        </li>
        <li class="nav-item">
          <a class="nav-link btn btn-danger" href="#">Appeals</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


<!--
This is nav bar for welcoming page
we will use php to determine which one 
to use according to user(guest - vote - candidate)
vote and candidate user will have same navbar
which is the above one
-->
<!--

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">WeVote</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor02">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="#">Log In</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Sign Up</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

-->
