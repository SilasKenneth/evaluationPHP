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
              if($module=="Student"){
                if(isset($_SESSION['student'])){
                PageHelper::render("./Student/nav.php");
              }
                PageHelper::render("404.php");
              }else{
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
