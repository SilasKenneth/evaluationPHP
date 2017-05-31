<?php
 require_once("loadall.php");
 ?>
 <?php define("SYSPATH",dirname(__FILE__));?>
 <div style="" >
  <?php
  if(!isset($_GET) || count($_GET)==0){
      PageHelper::render("home.php");
  }else{
      if(isset($_GET['page']) && isset($_GET['mod'])){
  $page = trim($_GET['page']);
  $module = trim($_GET['mod']);
  if(count($_GET)>=2){
      if(isset($_GET['page']) && isset($module) && trim($page)!='' && trim($module)!=''){
          $pg = PageHelper::render($module.DIRECTORY_SEPARATOR.$page.".php");
          if(!$pg){
              if($module=="Admin"){
                if(isset($_SESSION['administrator'])){
                    PageHelper::render("./Admin/nav.php");
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
                PageHelper::render("404.php");
              }
              else if($module=="Hod"){
                if(isset($_SESSION['hod'])){
                    PageHelper::render("./Hod/nav.php");
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
      <a class="navbar-brand" href="#"></a>
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
                PageHelper::render("404.php");
              }
              else if($module=="Lecturer"){
                if(isset($_SESSION['lecturer'])){
                    PageHelper::render("./Lecturer/nav.php");
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
      <a class="navbar-brand" href="#"></a>
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
                PageHelper::render("404.php");
              }
              else{
                 PageHelper::render("home.php");
              }
          }else{
              if(!PageHelper::render($module.DIRECTORY_SEPARATOR.$page.".php")){
                  PageHelper::render("home.php");
              }else{
                  PageHelper::render($module.DIRECTORY_SEPARATOR.$page.".php");
              }
          }
      }else{
          PageHelper::render("home.php");
      }
  }
  }
  else{
      PageHelper::render("home.php");
  }
  }
  ?>
  <?php
  /*
   * Using 10 to denote doesnt exist
   *
   */

  ?>
 </div>
