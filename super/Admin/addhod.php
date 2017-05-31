<?php
include_once 'nav.php';
include_once 'sidenav.php';
?>
<?php
$departments = Department::getAllDepartments();
?>
<?php
$error = NULL;
$success = NULL;
 if(isset($_POST['save'])){
     if(isset($_POST['names']) && isset($_POST['email']) && isset($_POST['department']) && isset($_POST['password'])){
         $names = trim($_POST['names']);
         $email = trim($_POST['email']);
         $department = trim($_POST['department']);
         $password = trim($_POST['password']);
         if(empty($names) || empty($email) || empty($department) || empty($password)){
             $error = "No field should be left empty";
         }else{
             if(HOD::AddNew($names, $email, $department, $password)){
                 $success = "The HOD was successfully saved";
                 Department::updateDepartment($department);
                 Department::updateCourses($department);
             }else{
                 $error = "An error just occured";
             }
         }
     }else{
         $error = "All fields are required";
     }
 }
?>
<?php if(!$departments){ ?>
<p class="alert alert-info">There are currently no departments please add some first</p>
<?php } else{ ?>
<div class="col-md-6 col-md-offset-4 col-sm-8 col-sm-offset-2 col-sm-offset-2 col-lg-6 col-lg-offset-4 endle">
    <form method="POST">
        <?php if(!isset($_POST['save'])){ ?>
        <h4 align="center">New Head of Department</h4>
        <?php } if(isset($error)) { ?>
        <p class="alert alert-danger"><?= $error ?></p>
        <?php } else if(isset ($success)) {?>
          <p class="alert alert-success"><?= $success ?></p>
        <?php
        }
        ?>
        <br>
        <input type="text" class="form-control" placeholder="Full names" name="names"><br>
        <input type="email" class="form-control" placeholder="Email address" name="email"><br>
        <b>Department</b>
        <br>
        <select name="department" class="form-control">
            <?php foreach ($departments as $department){ ?>
            <option value="<?= $department['id'] ?>"><?= $department['name'] ?></option>
            <?php } ?>
        </select>
        <br>
        <input type="password" class="form-control" placeholder="Password" name="password"><br>
        <hr>
        <button name="save" class="btn btn-info pull-right"><i class="fa fa-save"></i>    Save</button>
    </form>
</div>
<?php } ?>