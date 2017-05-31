<?php
?>
<?php
include_once "nav.php";
?>
<title>HOD - Addlec</title>
<?php 
include_once "sidenav.php";
?>
<?php
$defaultpass = NULL;
$fullnames = NULL;
$pass = NULL;
$idnumber = NULL;
$email = NULL;
$error = NULL;
$success = NULL;
if(isset($_POST['save'])){
    if(isset($_POST['lecname']) && isset($_POST['lecemail']) && isset($_POST['idnumber']) && isset($_POST['lecpass'])){
        $fullnames = trim($_POST['lecname']);
        $email = trim($_POST['lecemail']);
        $pass = trim($_POST['lecpass']);
        $idnumber = trim($_POST['idnumber']);
        if(empty($fullnames) || empty($email) || empty($pass) || empty($idnumber)){
            $error = "All the fields are required";
        }else{
            $lec = Lecturer::addLecturer($fullnames, $idnumber, $email, $pass);
            if(!$lec){
                $error = "The details could not be saved";
            }else{
                $success = "The record was successfully saved";
            }
        }
    }
}
if(isset($_POST['genid'])){
    if(isset($_POST['idnumber'])){
        $defaultpass = $_POST['idnumber'];
    }
        if(isset($_POST['lecname']) && isset($_POST['lecemail']) && isset($_POST['idnumber']) && isset($_POST['lecpass'])){
        $fullnames = trim($_POST['lecname']);
        $email = trim($_POST['lecemail']);
        $pass = trim($_POST['lecpass']);
        $idnumber = trim($_POST['idnumber']);
        if(empty($fullnames) || empty($email) || empty($pass) || empty($idnumber)){
            $error = "All the fields are required";
        }else{
//            $lec = Lecturer::addLecturer($fullnames, $idnumber, $email, $pass);
//            if(!$lec){
//                $error = "The details could not be saved";
//            }else{
//                $success = "The record was successfully saved";
//            }
        }
    }
}

?>
<div class="col-md-5 col-md-offset-4 col-sm-8 col-sm-offset-2 col-sm-offset-2 col-lg-4 col-lg-offset-4 endle">
    <form method="POST">
        <h4 align="center">New lecturer</h4>
        <hr>
        <div class="errors" style="height: 70px;">
           <?php
            if(isset($error)){
                ?>
            <p class="alert alert-danger"><?= $error ?></p>
            <?php
            }else{
                ?>
            <p class="alert alert-success"><?= $success ?></p>
            <?php
            }
           ?>
        </div>
        <input type="text" name="lecname" placeholder="Full name" class="form-control" value="<?php 
          if(isset($fullnames)){
              echo htmlspecialchars($fullnames);
          }?>" required><br>
        <input value="<?php 
          if(isset($email)){
              echo htmlspecialchars($email);
          }?>" type="email" class="form-control" name="lecemail" placeholder="Email address" required><br>
        <input value="<?php if(isset($idnumber)){
              echo htmlspecialchars($idnumber);
              
        }?>"  type="number" class="form-control" name="idnumber" min="20000000" max="50000000" placeholder="ID number" required><br>
        <div class="" style="display: block;overflow: hidden;">
            <input type="password" class="form-control pull-left" placeholder="Password" name="lecpass" value="<?php 
             if(isset($defaultpass)){
                 echo $defaultpass;
             }
             else if(isset($pass)){
                     echo $pass;
                 }
            ?>" required>
            <div class="clearfix"></div>
            <br>
            <button class="btn btn-success btn-xs pull-right" name="genid">Set to ID</button>
        </div>
        
        <hr>
        <button class="btn btn-info btn-sm" name="save" type="submit">Save record</button>
    </form>
</div>