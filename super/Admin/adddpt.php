<?php
include_once 'nav.php';
include_once 'sidenav.php';
?>
<?php
$departments = Department::getAllSchools();
?>
<?php
$error = NULL;
$success = NULL;
 if(isset($_POST['save'])){
     if(isset($_POST['name']) && isset($_POST['school'])){
         $school = trim($_POST['school']);
         $name = trim($_POST['name']);
         if(empty($name) || empty($school)){
             $error = "No field should be left empty";
         }else{
             if(Department::addDepartment($school, $name)){
                 $success = "Department was successfully saved";
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
        <h4 align="center">New Department</h4>
        <?php } if(isset($error)) { ?>
        <p class="alert alert-danger"><?= $error ?></p>
        <?php } else if(isset ($success)) {?>
          <p class="alert alert-success"><?= $success ?></p>
        <?php
        }
        ?>
        <br>
        <input type="text" class="form-control" placeholder="Department name" name="name"><br>
        <b>Department</b>
        <br>
        <select name="school" class="form-control">
            <?php foreach ($departments as $department){ ?>
            <option value="<?= $department['id'] ?>"><?= $department['title'] ?></option>
            <?php } ?>
        </select>
        <br>
        <hr>
        <button name="save" class="btn btn-info pull-right"><i class="fa fa-save"></i>    Save</button>
    </form>
</div>
<?php } ?>