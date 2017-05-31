<?php
include_once 'nav.php';
include_once 'sidenav.php';
$dpt = $_SESSION['hod']['department'];
$units = HOD::getDepartmentUnits($dpt);
$sorted = [];
?>
<div class="col-md-6 col-md-offset-4 col-sm-8 col-sm-offset-2 col-sm-offset-2 col-lg-6 col-lg-offset-3 form">
    <?php 
     if(!$units){
        ?>
       <p class="alert alert-warning">No units exist at the moment but you can add some</p>
    <?php
     }else{
         foreach ($units as $unit){
             if($unit['lecturer']==0){
                 array_push($sorted, $unit);
             }
         }
         if(!$sorted){
             ?>
       <p class="alert alert-info">Looks like all units are assigned to a lecturer maybe check back some day</p>
       <?php
         }else{
             ?>
       <h3 align="center">Unassigned units</h3>
       <br>
       <table class="table table-responsive table-bordered table-striped">
           <thead>
              <th>#</th>
              <th>Code</th>
              <th>Title</th>
           </thead>
           <tbody>
           <?php $i = 0; foreach($sorted as $item){
               $i++;
               ?>
           <tr>
               <td><?= $i ?></td>
               <td><?= $item['code'] ?></td>
               <td><?= $item['title'] ?></td>
           </tr>
               <?php
           }
           ?>
           </tbody>
       </table>
             <?php
             
         }
     } ?>
       
</div>