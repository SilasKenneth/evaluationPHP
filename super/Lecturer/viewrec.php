<title>My Recommendations</title>
<?php include_once 'nav.php';
$record = NULL;
$reco = NULL;
$bug = NULL;
if(isset($_GET['reco'])){
    $reco = trim($_GET['reco']);
    if(empty($reco)){
        $bug = "The ID was not found";
    }else{
        $record = Statistics::getRecommendByID($reco);
        if(!$record){
            $bug = "The record does not exist";
        }
    }
}else{
    $bug = "The ID was not found";
}

include_once 'sidenav.php';
?>
<?php
if($bug){
    ?>
<div class="col-md-7 col-md-offset-3 col-sm-10 col-sm-offset-1 col-lg-6 col-lg-offset-3 form">
    <p class="alert alert-danger"><?= $bug ?></p>
</div>
<?php
}else{
?>
<div class="col-md-7 col-md-offset-3 col-sm-10 col-sm-offset-1 col-lg-6 col-lg-offset-3 form">
    <p class="label label-primary"><?=    Units::getUnitDetails($record[0]['unit'])['code'] ?></p>
    <p class="label label-success"><?=    Units::getUnitDetails($record[0]['unit'])['title'] ?></p>
    <hr>
    <h3 align="center">Message</h3>
    <br>
    <p class="text-primary">
        <?= $record[0]['content'] ?>
     </p>
</div>
<?php } ?>