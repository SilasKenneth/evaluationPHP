<?php
include_once 'nav.php';
include_once 'sidenav.php';
$dp = $_SESSION['hod']['department'];
$years = Statistics::getYears();
$units = HOD::getDepartmentUnits($dp);
$sems = [1,2];
$records = NULL;
$error = NULL;
$total = NULL;
if(isset($_POST['find'])){
    if(isset($_POST['year']) && isset($_POST['unit'])){
        $unit = $_POST['unit'];
        $year = $_POST['year'];
        if(empty(trim($unit)) || empty(trim($year))){
            $error = "You never selected any Units or year";
        }else{
            $total = Statistics::countByUnit($unit,$year);
            if($total==0 || !$total){
                $records = NULL;
            }else{
              $records = Statistics::getUnitForYear($unit, $year);
            }
        }
        
    }else{
        $error  = "Please select a unit and year";
    }
    
}
?>
<div class="col-md-8 col-md-offset-4 col-sm-8 col-sm-offset-2 col-sm-offset-2 col-lg-8 col-lg-offset-3 form">
    <?php
    ?>
    <form class="form-inline noprint" method="post">
        <p class="form-group">
            <label for="year">Year:&nbsp;&nbsp;</label>
            <select class="form-control" id="year" name="year">
            <?php
              if($years){
                  foreach ($years as $year){
              ?>
            <option value="<?= $year['year'] ?>">
                <?= $year['year'] ?>
            </option>
              <?php } }?>
        </select>
        </p>
        &nbsp;&nbsp;
         <p class="form-group">
        <label for="unit">Unit:&nbsp;&nbsp;</label>
        <select class="form-control" id="unit" name="unit">
            <?php
              if($units){
                  foreach ($units as $unit){
              ?>
            <option value="<?= $unit['id'] ?>">
                <?= $unit['code']." ".$unit['title'] ?>
            </option>
              <?php } }?>
        </select>
        </p>
        &nbsp;&nbsp;
        <button class="btn btn-info btn-sm" name="find" type="submit">Load</button>
    </form>
    <hr>
    <?php if($records){ ?>
    <table class="table table-bordered table-striped print" >
        <thead>
          <th>#</th>
          <th>Registration</th>
          <th>Full names</th>
          <th>Total Classes</th>
          <th>Attended</th>
          <th>Missed</th>
          <th>% attendance</th>
        </thead>
        <tbody>
            <?php $i=0;foreach ($records as $record){ $i++;
            $perc = $total?(($record['total'])/$total)*100:0;
            $perc = $perc>100?100:$perc;
            ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $record['regno'] ?></td>
                <td><?= $record['names'] ?></td>
                <td><?= $total?$total:0 ?></td>
                <td><?= $record['total'] ?></td>
                <td><?= ($total-$record['total']) ?></td>
                <?php if($perc<50){ ?>
                <td class="bg-danger" ><?= round($perc,0)."%" ?></td>
                <?php }else{?>
                  <td class="bg-success" ><?=round($perc,0)."%" ?></td>
                <?php } ?>
            </tr>
            <?php }?>
        </tbody>
    </table>
    
    <?php } ?>
</div>

