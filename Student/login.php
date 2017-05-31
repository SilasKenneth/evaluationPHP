<?php
if(session_status()==1){
    session_start();
}
 abstract class studentlogin extends Login{
     public static function auth($regno,$password){
         try{
             $student = self::student($regno,$password);
             if(!$student) return false;
             $_SESSION['student'] = $student;
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
     if(isset($_POST['regno']) && isset($_POST['password'])){
         $regno = $_POST['regno'];
         $password = $_POST['password'];
         if(empty(trim($regno)) || empty(trim($password))){
             $error = "Please provide all details";
         }else{
            if(studentlogin::auth($regno, $password)){
                header("location: /Project/index.php?page=classes&mod=Student");
            }else{
                $error = "Wrong Reg. No or password";
            }
         }
     }else{
        
     }
 }
?>
<title>Login - Student</title>
<style>
    body{
        background: url("./images/bg.jpg");
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
          <li><a href="/Project/index.php?page=login&mod=Student">Login</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="col-md-5 col-md-offset-4 col-lg-4 col-lg-offset-4 col-sm-8 col-sm-offset-2 login1">
    <form method="post" style="margin-top: 20vh;">
        <h3 align="center" class="responsive-text text-theme" >Student</h3>
        <div class="clearfix"></div>
        <br>
        <?php if(isset($error)){?>
        <p class="alert alert-dismissible alert-danger"><?= htmlspecialchars($error) ?></p>
        <?php } ?>
        <br>
        <p class="form-group">
            <input type="text" name="regno" placeholder="Reg. No" class="form-control">
        </p>
        <p class="form-group">
            <input type="password" name="password" placeholder="Password" class="form-control">
        </p>
        <p class="form-group">
            <button type="submit" class="btn btn-info btn-sm pull-right btn-block" name="login">Sign in</button>
        </p>

        <p>
            <br><br><br>
        </p>
    </form>
</div>

