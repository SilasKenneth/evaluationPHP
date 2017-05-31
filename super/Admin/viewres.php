<?php
include_once "nav.php";
include_once 'sidenav.php';
?>
<style>
    .panel{
        width:40%;
    }
    .each{
        width:40%;
    }
</style>
<?php 
$error = NULL;
$evaluations = NULL;
$ev = NULL;
if(isset($_GET['evaluation'])){
    $ev = $_GET['evaluation'];
    if(trim($ev)==''){
        $error = "You never selected any evaluation";
    }else{
       $evaluations = Statistics::getAllRatingsByEvaluation($ev);
       if(!$evaluations){
           $error = "The evaluation specified does not have results yet or does not exist";
       }else{
           
       }
    }
}
?>
<div class="col-md-5 col-md-offset-4 col-sm-8 col-sm-offset-2 col-sm-offset-2 col-lg-8 col-lg-offset-3 form">
    <?php

     if(isset($error)){
    ?>
    <p class="alert alert-warning"><?= $error ?></p>
    <?php
     }else{
    ?>
    <table class="table table-striped table-bordered">
        <thead>
         <th>#</th>
         <th>Lecturer</th>
         <th>Unit code</th>
         <th>Unit name</th>
         <th>Score</th>
        </thead>
        <tbody>
            <?php
              $i = 0;
              if($evaluations){
                  
                  foreach($evaluations as $evaluation){
                      $i++;
               ?>
            <tr>
                <td>
                    <?= $i ?>
                </td>
                <td>
                    <?= $evaluation['fullnames'] ?>
                </td>
                <td>
                    <?= $evaluation['code'] ?>
                </td>
                 <td>
                    <?= $evaluation['title'] ?>
                </td>
                 <td>
                    <?= $evaluation['Average'] ?>
                </td>
            </tr>
            <?php
                  }
              }
            ?>
        </tbody>
    </table>
     <?php } ?>
</div>