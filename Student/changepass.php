<?php
include_once 'nav.php';
include_once 'sidenav.php';
$oldpass = $_SESSION['student']['password'];
$id = $_SESSION['student']['id'];
$error = NULL;
$success = NULL;
if(isset($_POST['save'])){
    if(isset($_POST['currentpass']) && isset($_POST['newpass'])){
       $pass = $_POST['currentpass'];
        $oldprovided = sha1(trim($pass));
        $newpass = $_POST['newpass'];
        if(empty(trim($newpass)) || empty(trim($pass))){
            $error = "Please provide all the fields";
        }else{
        if($oldprovided!=$oldpass){
            $error = "The current password provided does not march your current password";
        }else{
            
            if(Student::changePass($id, $oldpass, $newpass)){
                $success = "The password was successfully changed";
            }
        }
        }
    }
}
?>
<div class="col-md-4 col-md-offset-3 col-sm-10 col-sm-offset-1 col-lg-4 col-lg-offset-5 form">
    <form method="post">
    <h3 align="center">Change Password</h3>
    <hr>
    <?php if(isset($error)){ ?>
    <p class="alert alert-danger"><?= $error ?> </p>
    <?php } else if(isset($success)) { ?>
    <p class="alert alert-success"><?= $success ?></p>
    <?php } ?>
    <input type="password" placeholder="Current password" name="currentpass" class="form-control">
    <br>
    <input type="password" placeholder="New password" name="newpass" class="form-control">
    <br>
    <button type="submit" class="btn btn-primary pull-right" name="save">Save changes</button>
    </form>
</div>
