<?php
//Sessions here
?>
<?php
include_once "nav.php";
?>
<?php 
include_once "sidenav.php";
$evalutions = Evaluation::getActive();
$error = NULL;
$success = NULL;
if(isset($_POST['save'])){
    if(isset($_POST['ev']) && isset($_POST['quizt']) && isset($_POST['quiz'])){
        $q = $_POST['quiz'];
        $t = $_POST['quizt'];
        $ev = $_POST['ev'];
        $r = [$q,$t,$ev];
        if(!Settings::isEmpty($r)){
            $error = "Please provide the question";
        }else{
            if(Questionnare::addQuestion($t, $ev, $q)){
                $success = "The question was successfully added";
            }else{
                $error = "The question could not be saved";
            }
        }
    }
}
?>
<?php if(!$evalutions){
 
    ?>
<div class="col-md-8 col-md-offset-2 col-sm-12 col-sm-offset-2 col-lg-6 col-lg-offset-3 forms">
<p class="alert alert-danger">Please ensure that there is an active evaluation before you decide to click add questions. Or you can go under the evaluations menu and start an evaluation</p>
</div>
 <?php }else{
     
   ?>
<div class="col-md-5 col-md-offset-4 col-sm-8 col-sm-offset-2 col-sm-offset-2 col-lg-4 col-lg-offset-4 endle">
    <form method="post">
        <h4>Add Questions</h4>
        <hr>
        <?php
         if(isset($error)){
        ?>
        <p class="alert alert-danger"><?= $error ?></p>
        <?php 
         } else if(isset ($success)){
        ?>
        <p class="alert alert-success"><?= $success ?></p>
         <?php } ?>
        <b class="pull-left">Select evaluation</b>

        <div class="clearfix"></div>
        <br>
        <select name="ev" id="eval" class="form-control form-control-static">
            <option value="<?= $evalutions['id'] ?>">
                <?= Settings::formatdate($evalutions['startdate'])." - ".Settings::formatdate($evalutions['enddate']) ?>
            </option>
        </select>
        <br>
        <b>Question type</b>
        <br><br>
        <select name="quizt" id="quiztype" class="form-control form-control-static">
            <option value="2">
                Open ended
            </option>
            <option value="1">
                Rating type
            </option>
        </select>
        <br>
        <b>Question</b><br><br>
        <textarea name="quiz" id="quizcontent" cols="30" rows="5" class="form-control"></textarea>
        <hr>
        <button class="btn btn-info btn-sm pull-right" type="submit" name="save">Save and add another</button>
    </form>
</div>
<?php }
?>

