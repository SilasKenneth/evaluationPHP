<?php 
session_start();
if(isset($_SESSION['administrator'])){
  require_once "nav.php";
  require_once "sidenav.php";
}else{
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
          <li><a href="/Project/super/index.php?page=login&mod=Admin">Administrator</a></li>
           <li><a href="/Project/super/index.php?page=login&mod=Hod">HOD</a></li>
            <li><a href="/Project/super/index.php?page=login&mod=Lecturer">Lecturer</a></li>
      </ul>
    </div>
  </div>
</nav>
	<?php
}
//print_r($_SESSION);
?>
<div align="center">
<h1 class="error-title" align="center">
   Error 404
</h1>
<hr>
<h4>The page was not found</h4>
<br>
<br>
<br>
<?php if(isset($_SESSION['administrator'])){ ?>
<a href="/Project/super/index.php?page=evaluations&mod=Admin" class="btn btn-info" align="center">Go Back</a>
<?php } else { ?>
<a href="/Project/super/index.php?page=login&mod=Admin" class="btn btn-info" align="center">Login</a>
<?php } ?>
</div>
<style>
  .error-title{
      margin-top:30vh;
      font-size:45px;
  }
</style>
