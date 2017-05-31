<title>Initiate Class</title>
<?php include_once 'nav.php';
$records = Lecturer::myTodaySchedules($_SESSION['lecturer']['id']);
include_once 'sidenav.php';
$error = NULL;
$message = NULL;
$message1 = NULL;
if(isset($_GET['schedule'])){
    $ens = trim($_GET['schedule']);
    if(!empty($ens)){
        if(Schedules::initiated($ens)){
            $error = "Already initiated";
        }else{
           if(Schedules::initiateClass($ens)){
            $success = "Successfully initiated";
           }else{
            $message = "Could not be initiated";
          }
        }
    }
}

?>
<div class="col-md-7 col-md-offset-3 col-sm-10 col-sm-offset-1 col-lg-6 col-lg-offset-3 form">
    <?php
    if(isset($message)){ ?>
    <p class="alert alert-danger"><?= $message ?></p>
    <?php }else if(isset($error)){ ?>
    <?php
     ?>
    <p class="alert alert-danger"><?= $error ?></p>
    <?php } else if(isset ($success)) {?>
    <p class="alert alert-success"><?= $success ?> </p>
    <?php } ?>
</div>