<?php
?>
<?php
include_once "nav.php";
?>
<title>Admin Edit Student</title>
<?php 
include_once "sidenav.php";
$bug = NULL;
$student = NULL;
if(isset($_GET['student'])){
    $student = $_GET['student'];
    if(empty(trim($student))){
        $bug = "You never provided a student";
    }else{
        $record = Student::getByID($student);
        if(!$record){
            $bug = "The student does not exist";
        }else{
            
        }
    }
}else{
    $bug = "The student does not exist";
}
?>
<?php
$defaultpass = NULL;
$fullnames = NULL;
$pass = NULL;
$idnumber = NULL;
$email = NULL;
$error = NULL;
$success = NULL;
if(isset($_POST['save'])){
    if(isset($_POST['name']) && isset($_POST['regno']) && isset($_POST['course']) && isset($_POST['year']) && isset($_POST['sem']) && isset($_POST['pass'])){
        $fullnames = trim($_POST['name']);
        $regno = trim($_POST['regno']);
        $course = trim($_POST['course']);
        $year = trim($_POST['year']);
        $sem = trim($_POST['sem']);
        $pass = trim($_POST['pass']);
        $gender = trim($_POST['gender']);
        $insession = trim($_POST['insession']);
        if(empty($fullnames) || empty($regno) || empty($pass) || empty($sem) || empty($year) || empty($course)){
            $error = "All the fields are required";
        }else{
            $courselevel = 1;
            if(!Student::updateStudent($student,$regno, $fullnames, $pass, $course, $year, $sem, $gender, $insession)){
                $error = "The details could not be saved";
            }else{
                $success = "The record was successfully saved";
            }
        }
    }
}


?>
<?php
if(isset($bug)){
 ?>
<div class="col-md-6 col-md-offset-4 col-sm-8 col-sm-offset-2 col-sm-offset-2 col-lg-6 col-lg-offset-4 endle">
    <p class="alert alert-warning"><?= $bug ?></p>
</div>
<?php
}
else {?>
<div class="col-md-5 col-md-offset-4 col-sm-8 col-sm-offset-2 col-sm-offset-2 col-lg-4 col-lg-offset-4 endle">
    <form method="POST">
        <h4 align="center">Edit Student</h4>
        <hr>
           <?php
            if(isset($error)){
                ?>
            <p class="alert alert-danger"><?= $error ?></p>
            <?php
            }else if(isset ($success)){
                ?>
            <p class="alert alert-success"><?= $success ?></p>
            <?php
            }
           ?>
        <input type="text" name="name" placeholder="Full name" class="form-control" value="<?php 
          if(isset($fullnames)){
              echo htmlspecialchars($fullnames);
          } else {echo $record['names'];}?>" required>
        <br>
        <input type="text" name="regno" placeholder="Registration Number" class="form-control" value="<?php 
          if(isset($regno)){
              echo htmlspecialchars($regno);
          }else {echo $record['regno'];}?>" required>
        <br>
        <b>Course</b>
        <br>
        <br>
        <select class="form-control" name="course">
            <?php 
            $courses = HOD::getCourses();
            if($courses){
                foreach ($courses as $course){
                    ?>
            <option value="<?= $course['id'] ?>"><?= $course['title'] ?></option>
            <?php
                }
            }
            ?>
        </select>
        <br>
        <b>Year</b>
        <br>
        <select class="form-control" name="year">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        </select>
        <br>
        <select class="form-control" name="gender">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
        <br>
        <b>Semester</b>
        <br>
        
        <select class="form-control" name="sem">
            <option value="1">1</option>
            <option value="2">2</option>
        </select>
        <br>
        <b>In session? </b>
        <br>
        <select class="form-control" name="insession">
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>
        <br>
        <br>
        <input value="<?php 
          if(isset($pass)){
              echo htmlspecialchars($pass);
              }?>" type="password" class="form-control" name="pass" placeholder="Password" required><br>
        <hr>
        <button class="btn btn-info btn-sm" name="save" type="submit">Save record</button>
    </form>
</div>
<?php } ?>