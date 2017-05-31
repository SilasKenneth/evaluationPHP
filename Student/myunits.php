<title>My units</title>
<?php include_once 'nav.php';
$records = NULL;
$records = Student::getMyUnits($_SESSION['student']['course'],$_SESSION['student']['year'] ,$_SESSION['student']['sem']);

include_once 'sidenav.php';
?>
<div class="col-md-7 col-md-offset-3 col-sm-10 col-sm-offset-1 col-lg-6 col-lg-offset-3 form">
    <h3 align="center">My Units</h3>
    <br>
    <br>
    <table class="table table-striped table-responsive table-bordered">
        <thead>
        <th>#</th>
        <th>Title</th>
        <th>Lecturer</th>
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
                <td><?= Lecturer::getById($record['lecturer'])['fullnames'] ?></td>
            </tr>
            <?php
                 }
             }
            ?>
        </tbody>
    </table>
</div>