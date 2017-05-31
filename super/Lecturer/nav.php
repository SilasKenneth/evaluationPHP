<?php
 if(session_status()==1){
     session_start();
 }
 if(!Settings::makeSureUserIsLoggedIn("lecturer", "/Project/super/index.php?page=login&mod=Lecturer")){
     
 }
?>
<nav class="navbar navbar-default noprint">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Course Evaluation</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-bell"></i>  <?= htmlspecialchars($_SESSION['lecturer']['fullnames']) ?> &nbsp;<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="/Project/super/index.php?page=profile&mod=Lecturer"><i class="glyphicon glyphicon-user"></i>&nbsp;My Profile</a></li>
            <li><a href="/Project/super/index.php?page=settings&mod=Lecturer"><i class="glyphicon glyphicon-cog"></i>&nbsp;Settings</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="/Project/super/index.php?page=logout&mod=Lecturer"><i class="glyphicon glyphicon-log-out"></i>&nbsp;Log out</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>