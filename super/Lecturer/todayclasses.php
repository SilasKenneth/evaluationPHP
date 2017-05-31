<title>Todays classes</title>
<?php include_once 'nav.php';
$records = Lecturer::myTodaySchedules($_SESSION['lecturer']['id']);
include_once 'sidenav.php';
$error = NULL;
?>
<div class="col-md-7 col-md-offset-3 col-sm-10 col-sm-offset-1 col-lg-6 col-lg-offset-3 form">
    <h3 align="center">Classes today</h3>
    <br>
    <br>
    <table class="table table-striped table-responsive table-bordered">
        <thead>
        <th>#</th>
        <th>Title</th>
        <th>Start</th>
        <th>End time</th>
        <th>Attended?</th>
        </thead>
        <tbody>
            <?php
            $i = 0;
             if($records){
                 foreach ($records as $record){
                     $i++;
                     ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $record['title'] ?></td>
                <td><?= $record['begintime'] ?></td>
                 <td><?= $record['endtime'] ?></td>
                 <td>
                     <a href="/Project/super/index.php?page=confirmattendance&mod=Lecturer&unit=<?= $record['unit'] ?>" class="btn btn-info btn-xs">Confirm</a>
                     <?php if(!Schedules::initiated($record['id'])){ ?>
                        <a href="/Project/super/index.php?page=initiate&mod=Lecturer&schedule=<?= $record['id'] ?>" class="btn btn-success btn-xs">Initiate</a>
                     <?php } ?>
                 </td>
            </tr>
            <?php
                 }
             }
            ?>
        </tbody>
    </table>
        <br>
    
</div>

