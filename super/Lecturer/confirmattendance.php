<?php
   include_once 'nav.php';
   include_once 'sidenav.php';
   $unit = NULL;
   $error = NULL;
   $records = NULL;
   $res = [];
   $lecturer = $_SESSION['lecturer']['id'];
   if(isset($_GET['unit'])){
       $unit = trim($_GET['unit']);
       if(empty($unit)){
             $error =  "You never selected any unit";
       }else{
            if(!Schedules::checkHasClass($unit)){
                     $error = "The unit doesnt have a class today";
            }else{
           $records = Lecturer::getStudentsByUnit($lecturer,$unit);
           if(!$records){
                $error = "Sorry either you dont lecturer that unit or it doesnt exist at all please go back to <em>Todays classes</em> and make sure you choose the correct unit";
             }else{
                 foreach ($records as $record){
                     if(Schedules::inUnconfirmed($record['id'], $unit)){
                         array_push($res, $record);
                     }
                 }      
             }
             $records = $res;
            }
           }
   }
   
?>
<title>Confirm attendance</title>
<?php include_once 'nav.php';
include_once 'sidenav.php';
$error = NULL;
if(isset($_POST['save'])){
    if(count($_POST)==1){
        $error = "You never selected any student";
    }else{
        $s = array_slice($_POST, 0,count($_POST)-1);
        if(!$s){
            
        }else{
            $res = [];
            foreach ($s as $ss){
                Schedules::update($ss, $unit);
                $records = $res;
            }
            $records = Lecturer::getStudentsByUnit($lecturer,$unit);
           if(!$records){
                $error = "Sorry either you dont lecturer that unit or it doesnt exist at all please go back to <em>Todays classes</em> and make sure you choose the correct unit";
             }else{
                 $res = [];
                 foreach ($records as $record){
                     if(Schedules::inUnconfirmed($record['id'], $unit)){
                         array_push($res, $record);
                     }
                 }      
             }
             $records = $res;
            
        }
    }
}
?>
<?php 
  if(!$records){
?>
<div class="col-md-7 col-md-offset-3 col-sm-10 col-sm-offset-1 col-lg-6 col-lg-offset-3">
<p class="alert alert-warning">You never selected any units as a result you've got no attendance to confirm</p>
</div>
 <?php } else{ ?>
<div class="col-md-7 col-md-offset-3 col-sm-10 col-sm-offset-1 col-lg-6 col-lg-offset-3 form">
    <h3 align="center">Students signed</h3>
    <br>
    <br>
    <p class="label label-primary"><?=    Units::getUnitDetails($unit)['code'] ?> </p><p class="label label-success"><?= Units::getUnitDetails($unit)['title'] ?></p>
    <form method="post">
        <?php
     if(isset($error)){
    ?>
    <p class="alert alert-danger"><?= $error ?></p>
    <?php 
     }
     //print_r($records);
    ?>
    <table class="table table-striped table-responsive table-bordered">
        <thead>
        <th>#</th>
        <th>Reg. No</th>
        <th>Student name</th>
        <th>Attended?</th>
        </thead>
        <tbody>
            <?php
//            print_r($records);
            $i = 0;
             if($records){
                 foreach ($records as $record){
                     $i++;
                     ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $record['regno'] ?></td>
                <td><?= $record['names'] ?></td>
                <td><input type="checkbox" class="checkbox unchecked" value="<?= $record["id"] ?>" name="class<?= $i ?>"
                           <?php
                            if(isset($_POST['class'.$i])){
                                echo "checked";
                            }
                           ?>
                           > </td>
            </tr>
            <?php
                 }
             }
            ?>
        </tbody>
    </table>
        <br>
        <?php
        if($records){ ?>
        <button class="btn btn-success btn-xs pull-right" name="save">Confirm selected</button>
        <?php } ?>
</form>
    
</div>
 <?php } ?>

