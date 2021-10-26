<!--
This is nav bar 
we will use php to determine which one 
to use according to user(guest - vote - candidate)
vote and candidate user will have same navbar
-->


<?php

  //set session for user type
  // guest-voter-candidate
  session_start();
  if(isset($_POST['submit'])){
    //log out
    session_destroy();
    header('Location: /wevote/index.php');
  }
  $user_type = 'guest'; //start with guest by default
  if(isset($_SESSION['user_type'])){
      if($_SESSION['user_type']=='voter' or $_SESSION['user_type']=='candidate'){
        $user_type=$_SESSION['user_type'];
    }
  }
?>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/wevote/index.php">WeVote</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor02">
      <ul class="navbar-nav ms-auto">
        <?php if($user_type == 'voter' or $user_type=='candidate'):;?>
          <!--This item for candidate users only-->
          <?php if(isset($_SESSION['candidate'])):;?>
            <li class="nav-item">
              <a class="nav-link" href="/wevote/can_profile.php?updated_id=<?php echo $_SESSION['candidate']['id']?>">View My Profile</a>
            </li>
          <?php endif;?>
          <li class="nav-item">
            <a class="nav-link" href="/wevote/candidates.php">Candidates List</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/wevote/wvow">Leaderboard</a>
          </li>
          <li class="nav-item">
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
              <button type="submit" name="submit" class="btn btn-secondary" style="color: silver;">Log Out</button>
            </form>
          </li>
        <?php else:;?>
          <li class="nav-item">
            <a class="nav-link" href="/wevote/userlog/login.php">Log In</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Sign Up</a>
          </li>
        <?php endif;?>
      </ul>
    </div>
  </div>
</nav>
