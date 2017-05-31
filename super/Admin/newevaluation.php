<?php 
 if(session_status()<2){
 	session_start();
 }
 $emp  = null;
 $false = null;
 $true = null;
 $button = null;
 if(isset($_POST['save'])){
     $date = null;
     if(isset($_POST['enddate'])){
         $date = $_POST["enddate"];
     }
 	
 	$arr = [];
 	array_push($arr, $date);
 	if(!Settings::isEmpty($arr)){
 		$emp = "The end date is required";
 	}else{
             Evaluation::stopAllOthers();
 		$suv = Evaluation::startEvaluation($date);
 		if(!$suv) $false= "The evaluation could not be saved";
 		else{
 			$true = "Evaluation successfully saved";
 			$button = "<a class='btn btn-info btn-sm pull-left' href='/Project/index.php?page=addquizes&mod=Admin&evaluation=1'>Add questions</a>";
 		}
 	}
 }
include_once "nav.php";
?>
<title> Evaluation - Create </title>
<?php 
include_once "sidenav.php";
?>
<style type="text/css">

</style>

<div class="col-md-5 col-md-offset-4 col-sm-8 col-sm-offset-2 col-sm-offset-2 col-lg-4 col-lg-offset-4 form">
    <?php
    //print_r(Lecturer::myUnits(1));
    ?>
  <form method="POST" class="form-group newsuv">
       <?php if(!isset($_POST['save'])) {?><h3>New evaluation</h3><?php }?>
       <!-- Errors on my file -->
        <div class="alerts">
        <?php 
            if(isset($true) || isset($false) || isset($emp)){
        ?>
        <p class="alert <?php 
        if(isset($true)){
        	echo htmlspecialchars("label-success");
        }
        else{
        	echo htmlspecialchars("label-danger"); 
        }
        	?> white-text">
        <?php 
          if(isset($emp)){
          	?>
          	<i class="glyphicon glyphicon-flash"></i>&nbsp;&nbsp;&nbsp;
          	<?php 
          	echo htmlspecialchars($emp);
       ?>
       
       <?php } ?>
       <?php 
          if(isset($false)){
     ?>
          	<i class="glyphicon glyphicon-flash"></i>&nbsp;&nbsp;&nbsp;
          	<?php 
          	echo htmlspecialchars($false);
       ?>
       
       <?php } ?>
       <?php 
          if(isset($true)){
     ?>
          	<i class="glyphicon glyphicon-saved"></i>&nbsp;&nbsp;&nbsp;
          	<?php 
          	echo htmlspecialchars($true);
       ?>
       
       <?php } ?>
        </p>
        <?php }?>
        </div>
        <!-- End of errors -->
        <br>
        <hr>
      <b>End date of evaluation</b>
      <br><br>

    <div class="">
        <div class="date">
            <div class="input-group input-append date datepicker" id="datePicker">
               
                <input type="text" class="form-control datepicker" name="enddate" value="<?php
  	 	if(isset($_POST['enddate'])){echo htmlspecialchars($_POST['enddate']);}?>"/>
                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
            </div>
        </div>
    </div>
        	 <p>
         <?php
           if(isset($button)){
               echo $button;
           }
         ?>
         </p>
  <button class="btn btn-info btn-sm pull-right" name="save" type="submit">Save and add questions</button>
  	 
  </form>
</div>