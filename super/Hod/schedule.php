<?php
include_once 'nav.php';
include_once 'sidenav.php';
?>
<?php
$dept = $_SESSION['hod']['department'];
 $courses = HOD::getDepartmentCourses($dept);
 $units = HOD::getDepartmentUnits($dept);
 $days = ["Monday","Tuesday","Wednesday","Thursday","Friday"];
 $year = date("Y");
 function checkTime($time){
     $ne = explode(":", $time);
     if(count($ne)!=2){
         return FALSE;
     }
     if($ne[0]>12 ||$ne[0]<1 || $ne[1]>59 ||$ne[1]<0){
         return FALSE;
     }
     return TRUE;
 }
 $error = NULL;
 $success = NULL;
 if(isset($_POST['save'])){
     if(isset($_POST['course']) && isset($_POST['unit']) && isset($_POST['days']) && isset($_POST['begintime']) && isset($_POST['endtime'])){
         $course = $_POST['course'];
         $unit = $_POST['unit'];
         $day = $_POST['days'];
         $beg = $_POST['begintime'];
         $end = $_POST['endtime'];
         if(empty(trim($course)) || empty(trim($day)) || empty(trim($beg)) || empty(trim($end)) || empty(trim($unit))){
             $error = "All the details are required";
         }else{
             if(!checkTime($end) || !checkTime($beg)){
                 $error = "The times you provided are not of a good format";
             }else{
                 $beg = $beg.":00";
                 $end = $end.":00";
                 print_r($beg);
                 if(Schedules::addSchedule($day, $unit, $course, $beg, $end)){
                     $success = "The schedule was successfully saved";
                 }else{
                     $error  =  "The schedule could not be saved";
                 }
             }
         }
     }else{
         $error = "All the details are required";
     }
 }
?>
<div class="col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2 col-sm-offset-2 col-lg-4 col-lg-offset-4 form">
      <?php if(!isset($_POST['save'])) { ?><h3 align="center">Schedule Class</h3>
      <?php }if(isset($error)) { ?>
      <p class="alert alert-danger"><?= $error ?> </p>
      <?php } else if(isset($success)){ ?>
      <p class="alert alert-success"><?= $success ?> </p>
      <?php } ?>
      <form method="post">
      <br><br>
      <b>Course</b>
      <br>
      <br>
    <select name="course" class="form-control">
        <?php
        if($courses){
            foreach ($courses as $course){
        ?>
           <option value="<?= $course['id'] ?>"><?= $course['title'] ?></option>
        <?php }}
        ?>
    </select>
      <br>
      <b>Unit</b>
      <br>
      <br>
      <select name="unit" class="form-control">
        <?php
        if($units){
            foreach ($units as $unit){
        ?>
           <option value="<?= $unit['id'] ?>"><?= $unit['title'] ?></option>
        <?php }}
        ?>
    </select>
      <br>
      <b>Days of week </b>
       <br>
      <br>
      <select name="days" class="form-control">
          <?php
          $i = 0;
                  foreach ($days as $day){
                      $i++; 
          ?>
          <option value="<?= $i ?>"><?= $day ?></option>
          <?php
          
                  }
          ?>
      </select>
     
      <br>
      <b>Begin time</b>
      <br>
      <br>
      <input name="begintime" class="form-control" placeholder="HH:MM">
      <br>
      <b>End time</b>
      <br>
      <br>
      <input name="endtime" class="form-control" placeholder="HH:MM">
      <br>
      <p>
          <button class="btn btn-info btn-sm pull-right" type="submit" name="save">Save</button>
      </p>
      </form>
</div>