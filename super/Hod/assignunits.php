<?php
?>
<?php
include_once "nav.php";
?>
<title>HOD - Assign units</title>
<?php 
include_once "sidenav.php";
$units = NULL;
$lecturers = NULL;
$success = NULL;
$errors = NULL;
$unit = NULL;
$lec = NULL;
if(isset($_POST['save'])){
   if(isset($_POST['unit']) && isset($_POST['lecturer'])){
       $unit = trim($_POST['unit']);
       $lec = trim($_POST['lecturer']);
       if(empty($lec) || empty($unit)){
           $errors = "Please select all fields";
      }else{
          if(Units::assignUnits($lec, $unit)){
              $success = "Unit successfully assigned";
          }else{
              $errors = "Could not assign unit";
          }
      }
}
}
?>
<div class="col-md-5 col-md-offset-4 col-sm-8 col-sm-offset-2 col-sm-offset-2 col-lg-4 col-lg-offset-4 form">
    <form method="post">
        <h3 class="responsive-text" align="center">Assign units</h3><br>
        <?php if(isset($errors)){ ?>
        <p class="alert alert-danger"><?= htmlspecialchars($errors) ?></p>
        <?php } ?>
        <?php if(isset($success)){ ?>
        <p class="alert alert-success"><?= htmlspecialchars($success) ?></p>
        <?php } ?>
    <hr>
    <em>Lecturer</em>
    <br>
    
    <select name="lecturer" class="form-control">
         <?php
         $lecturers = Lecturer::getActive();
         if(!$lecturers){
             ?>
        <option>No units yet</option>
        <?php
         }else{
             foreach ($lecturers as $lecturer){
           ?>
        <option value="<?= htmlspecialchars($lecturer['id'])?>"><?= htmlspecialchars($lecturer['fullnames'])?></option>
        <?php
             }
         }
        ?>
    </select>
    <br>
    <em>Unit</em>
    <select name="unit" class="form-control">
        <?php
        $dep = $_SESSION['hod']['department'];
         $units = HOD::getDepartmentUnits($dep);
         if(!$units){
             ?>
        <option>No units yet</option>
        <?php
         }else{
             foreach ($units as $unit){
           ?>
        <option value="<?= htmlspecialchars($unit['id'])?>"><?= htmlspecialchars($unit['title'])?></option>
        <?php
             }
         }
        ?>
    </select>
    <hr>
    <?php if(isset($units) && isset($lecturers) && $units!=10 && $lecturers!=10){?>
    <button class="btn btn-success pull-right" name="save">Save </button>
    <?php } ?>
    </form>
</div>