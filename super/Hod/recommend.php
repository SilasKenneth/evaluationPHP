<?php
include_once 'nav.php';
include_once 'sidenav.php';
?>
<?php
$error = NULL;
$pass = FALSE;
$record = NULL;
$score = NULL;
$eve = NULL;
$lec = NULL;
if(!isset($_GET['unit']) || !isset($_GET['evaluation']) || !isset($_GET['lecturer'])){
    $error = "Unfortunately you never selected a lecturer to recommend. please use the links on the menu";
}else{
    $unit = trim($_GET['unit']);
    $evaluation = trim($_GET['evaluation']);
    $lecturer = trim($_GET['lecturer']);
    if(empty($unit) || empty($evaluation) || empty($lecturer)){
        $error = "We could not find the record you are trying to look for please check back the menu and make sure you find the correct info";
    }else{
       $record = Statistics::getToRecommend($lecturer, $unit, $evaluation);
       if(!$record){
           $error = "The information you are looking for is not available. make sure you clicked on the correct thing";
       }else{
           $score = ($record[0]['Average']/5)*100;
           if($score<50){
               $pass = FALSE;
           }else{
               $pass = TRUE;
           }
           $eve = Evaluation::getByID($evaluation);
           $lec = Lecturer::getById($record[0]['lec'])['fullnames'];
           if(!$lec){
               $error = "The lecturer seems not to be currently active. Contact the administrator on the same";
           }
       }
    }
}
?>
<?php 
if(isset($error)){
    
?>
<div class="col-md-6 col-md-offset-4 col-sm-8 col-sm-offset-2 col-sm-offset-2 col-lg-6 col-lg-offset-3 formx">
    <p class="alert alert-warning"><?= $error ?> </p>
</div>
<?php
}else{
    $bug = NULL;
    $success = NULL;
    if(isset($_POST['save'])){
        if(isset($_POST['comment'])){
            $comment = trim($_POST['comment']);
            if(empty($comment)){
                $bug = "Comment cannot be empty";
            }else{
                if(Lecturer::recommend($record[0]['lec'], $record[0]['unit'], $record[0]['evaluation'], $comment)){
                    $success = "Recommended successfully";
                }else{
                    $bug = "Something wrong happenned";
                }
            }
        }else{
            $bug = "Comment cannot be empty";
        }
    }
?>
<div class="col-md-6 col-md-offset-4 col-sm-8 col-sm-offset-2 col-sm-offset-2 col-lg-6 col-lg-offset-3 form">
    <?php if(!isset($success) && !isset($bug)){
      ?><h3 align="center" class="text-info">Recommend <em><?= $lec ?></em> for </h3>
    <?php
    }
      if(isset($bug)){
    ?>
    <p class="alert alert-danger"><?= $bug ?> </p>
      <?php }else if(isset ($success)){ ?>
    <p class="alert alert-success"><?= $success ?> </p>
      <?php } ?>
    <form method="post">
        <b>Unit</b>&nbsp;&nbsp;
        <p class="label label-primary"><?= $record[0]['code'] ?></p>
        <p class="label label-success">
            <?= $record[0]['title'] ?>
        </p>&nbsp;&nbsp;
        <br><br>
        <hr>
        <h3>Evaluation</h3>
        <hr>
        <b>Starting on </b>&nbsp;&nbsp;
        <p class="label label-primary">
            <?= Settings::formatdate($eve['startdate']) ?>
        </p>&nbsp;&nbsp;
        <b>Ending on</b>&nbsp;&nbsp;
        <p class="label label-primary">
            <?= Settings::formatdate($eve['enddate']) 
          ?>
           
        </p>&nbsp;&nbsp;
        <b>Score</b>&nbsp;&nbsp;
        <?php
        if(!$pass){ ?>
        <p class="label label-danger"><?= $score."%" ?></p>&nbsp;&nbsp;
        <?php } else { ?>
        <p class="label label-success"><?= $score."%" ?></p>&nbsp;&nbsp;
        <?php } ?>
        <br><br>
        <hr>
        <b>Write comment below</b>
        <br>
        <br>
        <p class="form-group">
            <textarea class="form-control" name="comment"></textarea>
        </p>
        <button class="btn btn-success pull-right" type="submit" name="save">Submit</button>
    </form>
</div>
<?php } ?>
