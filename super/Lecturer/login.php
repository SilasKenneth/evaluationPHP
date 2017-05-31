<?php
if(session_status()==1){
    session_start();
}
if(isset($_SESSION['lecturer'])){
    header("location:/Project/super/index.php?page=todayclasses&mod=Lecturer");
}
 abstract class lecturerlogin extends Login{
     public static function auth($lecturer,$password){
         try{
             $lecturer = self::lecturer($lecturer,$password);
             if(!$lecturer) return false;
             $_SESSION['lecturer'] = $lecturer;
             return true;
         }catch (Exception $ex){
             return false;
         }
     }
 }
?>
<?php
$error = null;
 if(isset($_POST['login'])){
     if(isset($_POST['email']) && isset($_POST['password'])){
         $email = $_POST['email'];
         $password = $_POST['password'];
         if(empty(trim($email)) || empty(trim($password))){
             $error = "Please provide all details";
         }else{
            if(lecturerlogin::auth($email, $password)){
                header("location: /Project/super/index.php?page=todayclasses&mod=Lecturer");
            }else{
                $error = "Email address or password is wrong";
            }
         }
     }else{
        
     }
 }
?>
<style>
    .form{
        margin-top: 25vh;
    }
</style>
<title>Login Lecturer</title>
<style>
    body{
        background: url("../images/bg1.jpg");
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
<div class="col-md-5 col-md-offset-4 col-lg-4 col-lg-offset-4 col-sm-8 col-sm-offset-2">
    <form method="post" class="form">
        
        <?php if(!isset($_POST['login'])){?><h3 align="center" class="responsive-text text-theme">Lecturer</h3>
        <?php }?>
        <div class="clearfix"></div>
       
        <?php if(isset($error)){?>
        <p class="alert alert-dismissible alert-danger"><?= htmlspecialchars($error) ?></p>
        <?php } ?>
        <br>
        <p class="form-group">
            <input type="text" name="email" placeholder="Email" class="form-control">
        </p>
        <p class="form-group">
            <input type="password" name="password" placeholder="Password" class="form-control">
        </p>
        <p class="form-group">
            <button type="submit" class="btn btn-info btn-sm pull-right btn-block" name="login">Sign in</button>
        </p>

        <p>
            <br><br>
    </form>
</div>
