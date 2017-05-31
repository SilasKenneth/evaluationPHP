<title>My units</title>
<?php include_once 'nav.php';
include_once 'sidenav.php';
$error = NULL;
$schedule = NULL;
$records = NULL;
if(isset($_GET['schedule'])){
    $schedule = $_GET['schedule'];
    if(trim($schedule)==''){
        $error = "You never selected any schedule to sign.We advice you find your todays classes by going to <b>Classes</b>-><b>Today's classes</b> and select <b>Sign</b>";
    }else{
        $records = Student::getClassName($schedule,$_SESSION['student']['sem'], $_SESSION['student']['year'], $_SESSION['student']['course']);
      if(!$records){
           $error = "You never selected any schedule to sign.We advice you find your todays classes by going to <b>Classes</b>-><b>Today's classes</b> and select <b>Sign</b>";
      }
    }
}else{
     $error = "You never selected any schedule to sign.We advice you find your todays classes by going to <b>Classes</b>-><b>Today's classes</b> and select <b>Sign</b>";
}

?>
<div class="col-md-7 col-md-offset-3 col-sm-10 col-sm-offset-1 col-lg-6 col-lg-offset-3 form">
  <?php 
   if(isset($error)){
     ?>
    <p class="alert alert-danger"><?=  $error ?></p>
    <?php
   }else{
       $records = Student::getClassName($schedule,$_SESSION['student']['sem'], $_SESSION['student']['year'], $_SESSION['student']['course']);
       if(!$records){
           $error = "You never selected any schedule to sign.We advice you find your todays classes by going to <b>Classes</b>-><b>Today's classes</b> and select <b>Sign</b>";
       }
       ?>
    <form method="post">
        <h4 align="center" class="text-center text-success "><?= htmlspecialchars($records['code'])."  ".  htmlspecialchars($records['title'])  ?></h4>
        <br><br>
        <input value="<?= Settings::getDayName(htmlspecialchars($records['days'])) ?>" class="form-control" name="day" disabled>
        <br><br>
        <input class="form-control" name="dates" value="<?= Date("jS F Y") ?>" disabled>
        <br><br>
        <div class="clearfix"></div>
        <button type="submit" name="save" class="pull-right btn btn-success">Sign</button>
    </form>
   <?php } ?>
</div>