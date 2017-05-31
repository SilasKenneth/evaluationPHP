<title>My units</title>
<?php include_once 'nav.php';
$records = NULL;
$records = Units::getLecturerUnits($_SESSION['lecturer']['id']);

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
        </thead>
        <tbody>
            <?php
            $i = 0;
             if($records){
                 $colors = ['success',"primary"];
                 foreach ($records as $record){
                     $i++;
                     ?>
            <tr>
                <?php
                
                $ra = array_rand($colors, 1);
                $ra1 = array_rand($colors, 1);
                //print_r($ra);
                ?>
                <td><?= $i ?></td>
                <td><p class="label label-<?php echo $colors[$ra1] ?>"><?= $record['code'] ?></p><p class="label label-<?php echo $colors[$ra] ?>"><?= $record['title'] ?></p></td>
            </tr>
            <?php
                 }
             }
            ?>
        </tbody>
    </table>
</div>