<title>Todays classes</title>
<?php include_once 'nav.php';
$records = Student::getMyClasses($_SESSION['student']['sem'], $_SESSION['student']['year'], $_SESSION['student']['course']);
$recora = NULL;
$student = $_SESSION['student']['id'];
if($records)$recora = Student::alreadyInitiated($records[0]['id']);
include_once 'sidenav.php';
$error = NULL;
if(isset($_POST['save'])){
    if(count($_POST)==1){
        $error = "You never selected any unit";
    }else{
        $recor = array_slice($_POST, 0,count($_POST)-1);
        $date = date("Y-m-d");
        foreach ($recor as $rec){
            Student::signAttendance($_SESSION['student']['id'],$date , 1, Schedules::getClassFromSchedule($rec)[0]['id']);
        }
    }
}
?>
<div class="col-md-7 col-md-offset-3 col-sm-10 col-sm-offset-1 col-lg-6 col-lg-offset-3 form">
    <h3 align="center">Classes today</h3>
    <br>
    <br>
    
    <form method="post">
        <?php
     if(isset($error)){
    ?>
    <p class="alert alert-danger"><?= $error ?></p>
    <?php 
     }
    ?>
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
            <?php if(Schedules::initiated($record['id']) && !Student::alreadySigned($student, $record['id'])) { ?>
            <tr>
                
                <td><?= $i ?></td>
                <td><?= $record['title'] ?></td>
                <td><?= $record['begintime'] ?></td>
                 <td><?= $record['endtime'] ?></td>
                 <td><input type="checkbox" class="checkbox unchecked" value="<?= $record["id"] ?>" name="class<?= $i ?>"> </td>
            </tr>
            <?php
             }
                 }
             }
            ?>
        </tbody>
    </table>
        <br>
        <button class="btn btn-success btn-xs pull-right" name="save">Sign selected</button>
</form>
    
</div>

