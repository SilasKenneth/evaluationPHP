<?php
?>
<?php
include_once "nav.php";
?>
<title>Admin Edit lecturer</title>
<?php 
include_once "sidenav.php";
$error = NULL;
$lecturer = NULL;
$opo = NULL;
if(isset($_GET['lecturer'])){
    $lec = $_GET['lecturer'];
    $id = NULL;
    if(empty(trim($lec))){
        $opo = "Unfortunately you never selected a lecturer";
    }else{
        $id = $_GET['lecturer'];
        $id = trim($id);
        $lecturer = Lecturer::checkAvailable($id);
        if(!$lecturer || $lecturer==10){
            $opo = "The lecturer was not found in our database we highly advice you use the navigation menu to find a lecturer to edit";
        }else{
            
        }
    }
    
}else{
    $error = "Please make sure you select a lecturer to edit";
}

?>
<?php
 if($opo){
     ?>
<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-sm-offset-2 col-lg-6 col-lg-offset-3 endle">
    <p class="alert alert-warning"><?= htmlspecialchars($opo) ?></p>
</div>
<?php
 }else{
?>
<?php
$defaultpass = NULL;
$fullnames = NULL;
$pass = NULL;
$idnumber = NULL;
$email = NULL;
$status = NULL;
$error = NULL;
$success = NULL;
$fine = NULL;
if(isset($_POST['save'])){
    if(isset($_POST['lecname']) && isset($_POST['lecemail']) && isset($_POST['idnumber']) && isset($_POST['lecpass'])){
        $fullnames = trim($_POST['lecname']);
        $email = trim($_POST['lecemail']);
        $pass = trim($_POST['lecpass']);
        $idnumber = trim($_POST['idnumber']);
        $status = trim($_POST['status']);
        if (!$status) {
                    $status = 0;
                }
                if(empty($fullnames) || empty($email) || empty($pass) || empty($idnumber)){
            $error = "All the fields are required";
        }else{
            if(!isset($lecturer)){
                $error = "You never selected any lecturer";
            }else{
                $lec = Lecturer::updateLecturer($lecturer['id'], $idnumber, $fullnames, $email, sha1($pass), $status);
            }
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
        <h4 align="center">Edit lecturer</h4>
        <hr>
        <div class="errors" style="height: 70px;">
           <?php
            if(isset($error)){
                ?>
            <p class="alert alert-danger"><?= $error ?></p>
            <?php
            }else{
                if(isset($success)){
                ?>
            <p class="alert alert-success"><?= $success ?></p>
            <?php
                }
            }
           ?>
        </div>
        <input type="text" name="lecname" placeholder="Full name" class="form-control" value="<?php 
          if(isset($fullnames)){
              echo htmlspecialchars($fullnames);
          }else{ echo $lecturer['fullnames']; }?>" required><br>
        <p class="label label-success">Active?</p>
        <br><br>
        <select class="form-control" name="status">
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>
        <br>
        <input value="<?php 
          if(isset($email)){
              echo htmlspecialchars($email);
          }else{ echo $lecturer['email']; } ?>" type="email" class="form-control" name="lecemail" placeholder="Email address" required><br>
        <input value="<?php if(isset($idnumber)){
              echo htmlspecialchars($idnumber);
              
        }else{ echo $lecturer['idnumber']; }?>"  type="number" class="form-control" name="idnumber" min="20000000" max="50000000" placeholder="ID number" required><br>
        <div class="" style="display: block;overflow: hidden;">
            <b>Currently ID number</b>
            <input type="password" class="form-control pull-left" placeholder="Password" name="lecpass" value="<?php 
             if(isset($defaultpass)){
                 echo $defaultpass;
             }
             else if(isset($pass)){
                     echo $pass;
                 }
                 else{ echo $lecturer['idnumber']; }
            ?>" required>
            <div class="clearfix"></div>
            <br>
            <button class="btn btn-success btn-xs pull-right" name="genid">Set to ID</button>
        </div>
        
        <hr>
        <button class="btn btn-info btn-sm" name="save" type="submit">Save record</button>
    </form>
</div>
 <?php } ?>