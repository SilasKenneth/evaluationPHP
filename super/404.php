<?php
require_once "loadall.php"; 
session_start();
if(isset($_GET['mod'])){
	if(!empty(trim($_GET['mod']))){
		if(isset($_SESSION['hod'])){
			header("location: /Project/super/index.php?page=404&mod=Hod");
		}else if(isset($_SESSION['administrator'])){
			header("location: /Project/super/index.php?page=404&mod=Admin");
		}else if(isset($_SESSION['student'])){
			header("location: /Project/index.php?page=404&mod=Student");
		}
	}
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
?>
<div align="center">
<h1 class="error-title" align="center">
   Error 404
</h1>
<br>
<br>
<br>
<a href="<?= $href ?>" class="btn btn-info" align="center">
    Go back
</a>
</div>
<style>
  .error-title{
      margin-top:30vh;
      font-size:45px;
  }
</style>
