<?php
?>
<?php
include_once "nav.php";
?>
<title>Admin - Assign units</title>
<?php 
include_once "sidenav.php";
//print_r(Evaluation::getActive());
?>
<div class="col-md-5 col-md-offset-4 col-sm-8 col-sm-offset-2 col-sm-offset-2 col-lg-7 col-lg-offset-3 form">
    <table class="table table-responsive table-striped">
        <thead>
          <th>RegNo</th>
          <th>Full name</th>
          <th>Course</th>
          <th>Insession</th>
          <th>Options</th>
        </thead>
        <tbody>
            <?php
            
              $lecs = Student::getAllStudents();
              if(!$lecs){}else{
                  if($lecs==10){
                      
                  }else{
                      foreach ($lecs as $luc){
                          
                          ?>
            <tr>
                <td><?= htmlspecialchars($luc['regno']) ?></td>
                 <td><?= htmlspecialchars($luc['names']) ?></td>
                 <td><?= htmlspecialchars(HOD::getCourseByID($luc['course'])[0]['title']) ?></td>
                 <td><?php if($luc['insession']==0){ ?>
                     <label class="btn btn-danger" disabled></label>
                 <?php } else{?>
                     <label class="btn btn-success" disabled></label>
                 <?php } ?>
                 </td>
                 <td><a class="btn btn-info btn-xs" href="/Project/super/index.php?page=editstudent&mod=Admin&student=<?= htmlspecialchars($luc['id']) ?>">Edit</a></td>
            </tr>
            <?php
                      }
                  }
              }
            ?>
        </tbody>
    </table>
</div>