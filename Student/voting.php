<?php
include_once  "nav.php"; 
include_once 'sidenav.php';

?>
<?php
$open = Questionnare::getQuestionByType(2);
$error = NULL;
$closed = Questionnare::getQuestionByType(1);
$sem = NULL;
$year = NULL;
$course = NULL;
$id = NULL;
if(isset($_SESSION)){
$sem = $_SESSION['student']['sem'];
$year = $_SESSION['student']['year'];
$course = $_SESSION['student']['course'];
$id = $_SESSION['student']['id'];
}
$pp = Student::getNotVoted($sem, $year, $course);
$pending = [];
if(!$pp){
    $pending=NULL;
}else{
    foreach ($pp as $p){
        if($p['lecturer']!=0){
            array_push($pending, $p);
        }
    }
}
$code = NULL;
$comments  =NULL;
$cur = NULL;
if(isset($_POST['save'])){
    $opens = count($open);
    $closes = count($closed);
    if(count($_POST)-2<($opens+$closes)){
        $error = "Please fill in all questuions";
    }else{
        if(!Settings::isEmpty($_POST)){
            $error = "All the fields are required";
        }else{
            $lecs = $_POST['lecturer'];
            $lecs = explode(",", $lecs);
            $comments = array_slice($_POST, count($closed)+1,count($_POST)-2);
            $comments = array_slice($comments, 0,  count($comments)-1);
            $comments = implode("-p-", $comments);
            $ratings = array_slice($_POST, 1,count($closed));
            $average =  array_sum($ratings)/count($closed);
            $code = round($average, 1);
            $unit = $lecs[0];
            $lec = $lecs[1];
            if(!$average){
                $error = "Please fill in all questuions";
            }else{
                if(Student::vote($id, $lec, $unit, $average, $comments)){
                    $success = "The form was succesfully submitted";
                    Student::markAsAlreadyVoted($id, $unit);
                    $pending = Student::getNotVoted($sem, $year, $course);
                }else{
                    $error = "Something went wrong";
                }
            }
        }
    }
}

?>
<div class="col-md-7 col-md-offset-6 col-lg-7 col-lg-offset-3 col-sm-8 col-sm-offset-2 votingpanel">
  
    <?php 
     if(!Evaluation::getActive()){
    ?>
    <p class="alert alert-info">There are currently no evaluations going on check back some day</p>
     <?php } else{ ?>
    <?php if(!$pending){ ?>
    <p class="alert alert-success">Congratulations you already finished your part on the evaluations phase we highly appreciate you efforts</p>
     <?php
    }else{
    ?>
<form method="post">
  <h2 align="center" class="text-theme quizhead">Complete the evaluation form below</h2>
  <hr>
    <?php
    //print_r($comments);
     if($error){
    ?>
  <p class="alert alert-danger"><?= $error ?></p>
     <?php }else if(isset ($success)){ ?>
  <p class="alert alert-success"><?= $success ?> </p>
     <?php } ?>
  <br>
    <b>Lecturer</b>
    <?php 
     //print_r($pending);
    ?>
    <select name="lecturer" class="form-control">
        <?php
            foreach ($pending as $pend){
                if($pend['lecturer']){
         ?>
             <option value="<?= htmlspecialchars($pend['id']).','.  htmlspecialchars($pend['lecturer'])?>"><?=  htmlspecialchars($pend['code'])." - ".Lecturer::getById($pend['lecturer'])['fullnames'] ?></option>
            <?php
            }
            }
        ?>
    </select>
<!--Start of question-->
    <?php
//   print_r($pending);
   // print_r($_SESSION);
    global $j;
    $j = 0;
 if($closed){
     $i = 0;

     foreach ($closed as $item){
         $j++;
         $i++;
         ?>
         <div class="questions">
             <p class="question-text">
                 <b><?= $j ?></b> <em><?= htmlspecialchars($item['bodytext']) ?></em>
             </p>
             <br><br>
             <p class="input-group">
                 <input type="radio" name="rating<?= $i ?>" class="radiobuttons unchecked" id="five<?= $i ?>" <?php
                   if(isset($_POST['rating'.$i]) && $_POST['rating'.$i]==5){echo "checked=checked";}
                 ?>value="5">&nbsp;&nbsp;<label class="" for="five<?= $i ?>">Excellent</label>&nbsp;&nbsp;&nbsp;&nbsp;
                 <input type="radio" name="rating<?= $i ?>" class="radiobuttons unchecked" id="four<?= $i ?>"
                 <?php
                 if(isset($_POST['rating'.$i]) && $_POST['rating'.$i]==4){echo "checked=checked";} ?>
                 value="4">&nbsp;&nbsp;<label class="" for="four<?= $i ?>">Very Good</label>&nbsp;&nbsp;&nbsp;&nbsp;
                 <input type="radio" name="rating<?= $i ?>" class="radiobuttons unchecked" id="three<?= $i ?>"

                     <?php
                     if(isset($_POST['rating'.$i]) && $_POST['rating'.$i]==3){echo "checked=checked";} ?>
                        value="3">&nbsp;&nbsp;<label class="" for="three<?= $i ?>">Good</label>&nbsp;&nbsp;&nbsp;&nbsp;
                 <input type="radio" name="rating<?= $i ?>" class="radiobuttons unchecked" id="two<?= $i ?>"
                     <?php
                     if(isset($_POST['rating'.$i]) && $_POST['rating'.$i]==2){echo "checked=checked";} ?>
                        value="2">&nbsp;&nbsp;<label class="" for="two<?= $i ?>">Average</label>&nbsp;&nbsp;&nbsp;&nbsp;
                 <input type="radio" name="rating<?= $i ?>" class="radiobuttons unchecked" id="one<?= $i ?>"
                     <?php
                     if(isset($_POST['rating'.$i]) && $_POST['rating'.$i]==1){echo "checked=checked";} ?>
                        value="1">&nbsp;&nbsp;<label class="" for="one<?= $i ?>">Poor</label>
             </p>
             <br>
         </div>
    <?php
     }
 }
 if($open){

     $i = 0;
     foreach ($open as $item) {
         $j++;
         $i++;
         ?>
    <div class="questions">
         <p class="question-text">
             <b><?= $j ?></b> <em><?= htmlspecialchars($item['bodytext']) ?></em>
         </p
         <br>
         <br>
         <input type="text" name="comment<?= $i ?>" class="form-control" value="<?php
         
         if(isset($_POST["comment".$i])){echo htmlspecialchars($_POST['comment'.$i]);} ?>">
    </div>
    <?php
     }
 }
 ?>

<!--    End of question-->
<hr>
   <p>
   	<button class="btn btn-success btn-md pull-right" type="submit" name="save" value="Yes">Submit form</button>
   </p>
</form>
     <?php } } ?>
</div>
 <script type="text/javascript" src="js/app.js"></script>
 <script type="text/javascript" src="js/icheck.js"></script>