<?php
?>
<?php
include_once "nav.php";
?>
<title>Admin - Discontinue lecturer</title>
<?php 
include_once "sidenav.php";
$units = NULL;
$lecturers = NULL;
$message = NULL;
if(isset($_POST['save'])){
    if(isset($_POST['lecturer'])){
        $id = $_POST['lecturer'];
        $ds = Lecturer::discontinue($id);
        if(!$ds){
            $message = "An error occured";
        }else{
            $sq = Units::discontinueUnits($id);
            $message = "Successfully discontinued";
        }
    }
}
?>
<div class="col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2 col-sm-offset-2 col-lg-4 col-lg-offset-4 form">
    <form method="post"> 
    <h4 align="center">Discontinue Lecturer</h4>
     <hr>
     <div class="errors">
         <?php 
           if(isset($message)){?>
         <p class="alert alert-success"> <?= htmlspecialchars($message) ?></p>
               <?php
           }
         ?>
     </div>
     <p align="center">Lecturer</p><br>
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
    <br><br>
    <button class="btn btn-danger btn-md pull-right" name="save" type="submit">Discontinue selected</button>
    </form>
</div>