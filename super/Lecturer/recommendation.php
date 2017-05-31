<?php
include_once 'nav.php';
include_once 'sidenav.php';
$lec = $_SESSION['lecturer']['id'];
$records = Statistics::recommendations($lec);
?>
<div class="col-md-8 col-md-offset-4 col-sm-8 col-sm-offset-2 col-sm-offset-2 col-lg-8 col-lg-offset-3 form">
    <h3 align="cemter">Recommendations</h3>
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
         <th>Unit</th>
         <th>Message</th>
         <th>Actions</th>
        </thead>
        <tbody>
            <?php
              $i = 0;
              if($records){
                  
                  foreach($records as $record){
                      $i++;
               ?>
            <tr>
                <td>
                    <?= $i ?>
                </td>
                <td>
                    <?= Units::getUnitDetails($record['unit'])['title'] ?>
                </td>
                <td>
                    <?= $record['content'] ?>
                </td>
                <td>
                    <a class="btn btn-info btn-xs" href="/Project/super/index.php?page=viewrec&mod=Lecturer&reco=<?= $record['id'] ?>">View</a>
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