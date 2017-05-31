<?php
?>
<?php 
  include_once "nav.php";
  include_once 'sidenav.php';
  $success = NULL;
  if(isset($_POST['save'])){
      if(isset($_POST['about']) && isset($_POST['coursetitle'])){
          $about = trim($_POST['about']);
          $department = $_SESSION['hod']['department'];
          $school = Student::getDepartmentSchool($department)[0]['school'];
          $coursetitle = trim($_POST['coursetitle']);
          if(empty($about) || empty($school) || empty($coursetitle) || empty($department)){
              $error = "Please provide all the fields";
          }else{
              if(Student::addCourse($coursetitle, $school, $department,$about)){
                  $success = "The course was successfully added";
              }
          }
      }else{
          $error = "Please fill all the fields";
      }
  }
?>
<title>HOD - Add course</title>
<div class="col-md-5 col-md-offset-4 col-sm-8 col-sm-offset-2 col-sm-offset-2 col-lg-4 col-lg-offset-4 endle">
  <form method="POST">
  
  <?php 
    if(!isset($_POST['save'])){
  ?><h4>Create course</h4>
  <?php }
  if(isset($error)){
  ?>
  <p class="alert alert-warning"><?= $error ?></p>
  <?php } else if(isset ($success)){?>
  <p class="alert alert-success"><?= $success ?></p>
  <?php } ?>
  <br>
  	<input type="text" name="coursetitle" class="form-control" placeholder="Course title"><br>
        <br>
  	<br>
  	<label>Course description</label><br>
        <textarea name="about" class="form-control" rows="5" cols="20"></textarea>
  	<hr>
  	<button class="btn btn-info btn-sm pull-right" name="save">Save record</button>
  </form>
</div>