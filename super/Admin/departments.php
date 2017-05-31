<?php
?>
<?php
include_once "nav.php";
?>
<title>Admin - Departments</title>
<?php 
include_once "sidenav.php";
//print_r(Evaluation::getActive());
?>
<div class="col-md-5 col-md-offset-4 col-sm-8 col-sm-offset-2 col-sm-offset-2 col-lg-7 col-lg-offset-3 form">
    <table class="table table-responsive table-striped">
        <thead>
          <th>#</th>
          <th>Department name</th>
          <th>HOD</th>
        </thead>
        <tbody>
            <?php
            
              $lecs = Department::getAllDepartments();
              if(!$lecs){}else{
                  if($lecs==10){
                      
                  }else{
                      $i = 0;
                      foreach ($lecs as $luc){
                          $i++;
                          ?>
            <tr>
                <td><?= $i ?></td>
                 <td><?= htmlspecialchars($luc['name']) ?></td>
                 <td><?= htmlspecialchars(HOD::getById($luc['hod'])) ?></td>
            </tr>
            <?php
                      }
                  }
              }
            ?>
        </tbody>
    </table>
</div>

