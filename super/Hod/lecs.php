<?php
?>
<?php
include_once "nav.php";
?>
<title>Admin - Assign units</title>
<?php 
include_once "sidenav.php";
?>
<div class="col-md-5 col-md-offset-4 col-sm-8 col-sm-offset-2 col-sm-offset-2 col-lg-6 col-lg-offset-4 endle">
    <?php 
    $dep = $_SESSION['hod']['department'];
    ?>
    <table class="table table-responsive table-striped">
        <thead>
          <th>ID number</th>
          <th>Full name</th>
          <th>Email</th>
          <th>Options</th>
        </thead>
        <tbody>
            <?php
              $lecs = HOD::getLecturersByDepartments($dep);
              if(!$lecs){}else{
                  if($lecs==10){
                      
                  }else{
                      foreach ($lecs as $luc){
                          ?>
            <tr>
                <td><?= htmlspecialchars($luc['idnumber']) ?></td>
                 <td><?= htmlspecialchars($luc['fullnames']) ?></td>
                 <td><?= htmlspecialchars($luc['email']) ?></td>
                 <td><a href="/Project/super/index.php?page=editlec&mod=Hod&lecturer=<?= $luc['id'] ?>" class="btn btn-info btn-xs">Edit</a></td>
            </tr>
            <?php
                      }
                  }
              }
            ?>
        </tbody>
    </table>
</div>
