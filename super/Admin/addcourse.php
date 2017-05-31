<?php
?>
<?php 
  include_once "nav.php";
  include_once 'sidenav.php';
  $schools = Student::getAllSchools();
  $departments = Student::getDepartment();
  $success = NULL;
  if(isset($_POST['save'])){
      if(isset($_POST['about']) && isset($_POST['school']) && isset($_POST['coursetitle']) && isset($_POST['department'])){
          $about = trim($_POST['about']);
          $school = trim($_POST['school']);
          $department = trim($_POST['department']);
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
<title>Admin - Change Password</title>
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
  	<label for="school">School</label><br>
  	<select class="form-control" id="school" name="school">
  		<?php
                 if($schools){
                     foreach ($schools as $schooler){
                ?>
            <option value="<?= $schooler['id'] ?>"><?= $schooler['title'] ?></option>
                 <?php } }?>
  	</select>
        <br>
        <label for="deparment">Department</label>
        <select class="form-control" id="department" name="department">
  		<?php
                 if($departments){
                     foreach ($departments as $department){
                ?>
            <option value="<?= $department['id']?>"><?= $department['name'] ?></option>
                 <?php } }?>
  	</select>
  	<br>
  	<label>Course description</label><br>
        <textarea name="about" class="form-control" rows="5" cols="20"></textarea>
  	<hr>
        <?php
        if($schools && $departments){
        ?>
  	<button class="btn btn-info btn-sm pull-right" name="save">Save record</button>
        <?php } ?>
  </form>
</div>