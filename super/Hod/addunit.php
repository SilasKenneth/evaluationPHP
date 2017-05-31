<?php
?>
<?php
include_once "nav.php";
?>
<title>HOD - Add unit</title>
<?php 
include_once "sidenav.php";
  $department = $_SESSION['hod']['department'];
  $records = HOD::getDepartmentCourses($department);
  if(isset($_POST['save'])){
      if(isset($_POST['code']) && isset($_POST['description']) && isset($_POST['title'])){
          $code = $_POST['code'];
          $title = $_POST['title'];
          $description = $_POST['description'];
          $year = $_POST['year'];
          $semester = $_POST['sem'];
          $status = 1;
          $course = $_POST['course'];
          if(empty(trim($code)) || empty(trim($title)) || empty(trim($description))){
              $error = "The description title and code cannot be empty";
          }else{
              if(Units::addUnit($year, $course, $semester, $title, $description, 0, $status)){
                  $success = "The unit was successfully added";
              }else{
                  $error = "Sorry the unit could not be saved";
              }
          }
      }else{
          $error = "The description title and code cannot be empty";
      }
  }
?>
<?php
if(!isset($records)){
    ?>
<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-sm-offset-2 col-lg-6 col-lg-offset-4 endle">
    <p class="alert alert-warning">There are currently no courses in your department</p>
</div>
<?php
}
?>
<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-sm-offset-2 col-lg-4 col-lg-offset-4 endle">
    <form method="POST">
        <?php if(!isset($error) && !isset($success)){ ?>
        <h4 align="center">New unit</h4>
        <?php } else if(isset ($error)){ ?>
        <p class="alert alert-danger"><?= $error ?></p>
        <?php } else if(isset($success)){
            ?>
        <p class="alert alert-success"><?= $success ?></p>
        <?php } ?>
        <hr>
        <b>Course</b>
        <br><br>
        <select name="course" class="form-control">
            <?php
            foreach ($records as $record){
            ?>
            <option value="<?= $record['id'] ?>"><?= $record['title'] ?></option>
            <?php } ?>
        </select>
        <br>
        <b>Year of Study</b>
        <br><br>
        <select name="year" class="form-control">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <br>
        <b>Semester</b>
        <br><br>
        <select name="sem" class="form-control">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
        </select>
        <br>
        <input type="text" placeholder="Unit code" name="code" class="form-control">
        <br>
        <br>
        <input type="text" placeholder="Unit  title" name="title" class="form-control">
        <br>
        <b>Unit Description</b>
        <br>
        <br>
        <textarea class="form-control" name="description" rows="3"></textarea>
        <hr>
        <button class="btn btn-sm btn-success" name="save">Save unit</button>
    </form>
</div>