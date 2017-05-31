<?php
if(session_status()==1){
    session_start();
}
if(isset($_SESSION['hod'])){
    header("location:/Project/super/index.php?page=lecs&mod=Hod");
}
 abstract class hodlogin extends Login{
     public static function auth($email,$password){
         try{
             $hod = self::hod($email,$password);
             if (!$hod) {
                return false;
            }
            $_SESSION['hod'] = $hod;
             return true;

         }catch (Exception $ex){
             return false;
         }
     }
 }
?>
<?php
$error = NULL;
 if(isset($_POST['login'])){
     if(isset($_POST['hodemail']) && isset($_POST['hodpassword'])){
         $hodemail = $_POST['hodemail'];
         $hodpassword = $_POST['hodpassword'];
         if(empty(trim($hodemail)) || empty(trim($hodpassword))){
             $error = "Please provide all details";
         }else{
            if(hodlogin::auth($hodemail, $hodpassword)){
                header("location: /Project/super/index.php?page=lecs&mod=Hod");
            }else{
                $error = "Wrong username or password";
            }
         }
     }else{
        
     }
 }
?>

<title>Login - HOD</title>
<style>
    body{
        background: url("./images/bg1.jpg");
        background-attachment: fixed;
        background-size: cover;
    }
</style>
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
<div class="col-md-5 col-md-offset-4 col-lg-4 col-lg-offset-4 col-sm-8 col-sm-offset-2 login1">
    <form method="post"  style="margin-top:20vh;">
        <h3 align="center" class="responsive-text text-theme">HOD</h3>
        <div class="clearfix"></div>
        <br>
        <?php if(isset($error)){?>
        <p class="alert alert-danger"><?= htmlspecialchars($error) ?></p>
        <?php } ?>
        <br>
        <p class="form-group">
            <input type="text" name="hodemail" placeholder="Email" class="form-control">
        </p>
        <p class="form-group">
            <input type="password" name="hodpassword" placeholder="Password" class="form-control">
        </p>
        <p class="form-group">
            <button type="submit" class="btn btn-info btn-sm pull-right btn-block" name="login">Sign in</button>
        </p>

        <p>
            <br><br>
        </p>
    </form>
</div>