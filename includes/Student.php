<?php
abstract class Student extends DB {
    public static function getClassName($id,$sem,$year,$course){
        try{
            $record = self::getMyClasses($sem, $year, $course);
            if(!$record){
                return FALSE;
            }
            foreach($record as $rec){
                if($rec['id']==$id){
                    return $rec;
                }
            }
            return FALSE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public static function getMyClasses($sem,$year,$course){
        try{
            $sql = "SELECT units.code,schedules.days,units.title,schedules.id,schedules.begintime,schedules.endtime FROM schedules INNER JOIN units on schedules.unit=units.id WHERE units.course=? and units.semester=? and units.year=? and days=?";
            if (self::getError()){
                return FALSE;
            }
            $cn = self::connect();
            $day = strftime("%w");
            $qr = $cn->prepare($sql);
            $qr->bindParam(1,$course);
            $qr->bindParam(2, $sem);
            $qr->bindParam(3, $year);
            $qr->bindParam(4, $day);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            $records = $qr->fetchAll(PDO::FETCH_ASSOC);
            return $records;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    //TODO Complete all the function here
    public static function addNew($regno,$names,$password,$course,$year,$semester,$gender,$courselevel){
        try{
            if(self::getError()) return false;
            $cn = self::connect();
            $sql ="INSERT INTO students(regno,names,password,course,year,sem,gender,courselevel,insession)VALUES(?,?,?,?,?,?,?,?,?)";
            $qr = $cn->prepare($sql);
            $qr->bindParam(1,$regno);
            $insession = 1;
            $password = sha1($password);
            $qr->bindParam(2,$names);
            $qr->bindParam(3,$password);
            $qr->bindParam(4,$course);
            $qr->bindParam(5,$year);
            $qr->bindParam(6,$semester);
            $qr->bindParam(7,$gender);
            $qr->bindParam(8,$courselevel);
            $qr->bindParam(9,$insession);
            if(!$qr)return false;
            $qr->execute();
            return true;
        }catch (Exception $ex){
            //print_r($ex);
            return false;
        }
    }
    public static function getAllStudents(){
        try{
            if(self::getError()) return false;
            $sql = "SELECT * FROM students ORDER BY regno ASC";
            $qr = self::connect()->prepare($sql);
            if(!$qr) return false;
            $qr->execute();
            $records = $qr->fetchAll(PDO::FETCH_ASSOC);
            if(!$records) return 10;
            return $records;
        }catch (Exception $ex){
            return false;
        }
    }
    public static function getStudentByCourse($course){
        try{
            if(!self::getAllStudents()) return [];
            $studs = self::getAllStudents();
            if(count($studs)<1) return false;
            $res = array();
            foreach ($studs as $stud){
                if($stud['course']==$course){
                    array_push($res,$stud);
                }
            }
            return $res;
        }catch (Exception $ex){
            return false;
        }
    }

    /*********************************************************************
     * Get the units of the currently logged in student
     ***********************************************************************/
    public static function getMyUnits($course,$year,$semester){
        try{
            $units = Units::getUnitsByClass($course,$year,$semester);
            if($units==10) return 10;
            if(!$units) return false;
            return $units;
        }catch (Exception $ex){
            return false;
        }
    }
    public static function signAttendance($student,$date,$value,$schedule){
        try{
            $sql = "insert into attendance(student,value,dates,confirmed,class,year_attended)VALUES(?,?,?,?,?,?)";
            if(self::getError()){
                return FALSE;
            }
            $cn = self::connect();
            $year = date("Y");
            $qr = $cn->prepare($sql);
            $confirmed = 0;
            $qr->bindParam(1,$student);
            $qr->bindParam(2,$value);
            $qr->bindParam(3,$date);
            $qr->bindParam(4,$confirmed);
            $qr->bindParam(5,$schedule);
            $qr->bindParam(6,$year);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            return TRUE;
        }catch (Exception $ex){
            //print_r($ex);
            return false;
        }
    }
    /*******************************************************
     * alreadyInitiated(@param)
     * Find all the units which have already been initiated
     *******************************************************/
    public static function alreadyInitiated($schedule){
        try{
            $date = date("Y-m-d");
            $sql = "SELECT * FROM classes WHERE thatdate=? AND schedule=?";
            if(self::getError()){
                return FALSE;
            }
            $qr = self::connect()->prepare($sql);
            $qr->bindParam(1,$date);
            $qr->bindParam(2,$schedule);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            $records = $qr->fetchAll(PDO::FETCH_ASSOC);
            if(!$records){
                return FALSE;
            }
            return $records;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    public static function getUnitFromSchedule($schedule){
        try{
            $elems = self::getAllClasses();
            if(!$elems){
                return FALSE;
            }
            foreach ($elems as $elem){
                if($elem['schedule']==$schedule){
                    return $elem;
                }
            }
            return FALSE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    public static function getAllClasses(){
        try{
            $date = date("Y-m-d");
            $sql = "SELECT * FROM classes WHERE thatdate=?";
            if(self::getError()){
                return FALSE;
            }
            $qr = self::connect()->prepare($sql);
            $qr->bindParam(1,$date);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            $records = $qr->fetchAll(PDO::FETCH_ASSOC);
            if(!$records){
                return FALSE;
            }
            return $records;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    public static function getAttendanceByStudent($id){
        try{
            $res = [];
            $att = self::getAllAttendance();
            if(!$att){
                return FALSE;
            }
            foreach ($att as $et){
                if($et['student']==$id){
                    array_push($res, $et);
                }
            }
            return $res;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    public static function getAttendanceByUnit($id){
        try{ 
            $students = self::getAllAttendance();
            if(!$students){
                return FALSE;
            }
            $res = [];
//             print_r($students);
            foreach ($students as $student){
                if(Schedules::getUnitFromSchedule($student['class'])==$id){
                    array_push($res, $student);
                }
            }
            return $res;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    public static function getOnlyUnConfirmed($unit){
        try{
            $res = [];
            $records = self::getAttendanceByUnit($unit);
            if(!$records){
                return FALSE;
            }
            foreach ($records as $record){
                if($record['confirmed']==0){
                    array_push($res, $record);
                }
            }
            return $res;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    public static function studentRegAndName($id){
        try{
            
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    public static function getAttendanceToday($unit){
        try{
            $date = date("Y-m-d");
            $res = [];
            $att = self::getOnlyUnConfirmed($unit);
            if(!$att){
                return FALSE;
            }
            foreach ($att as $et){
                if($et['dates']==$date){
                    array_push($res, $et);
                }
            }
            return $res;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    public static function getAllAttendance(){
        try{
            
            $date = date("Y-m-d");
            $sql = "SELECT * FROM attendance";
            if(self::getError()){
                return FALSE;
            }
            $qr = self::connect()->prepare($sql);
            $qr->bindParam(1,$date);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            $records = $qr->fetchAll(PDO::FETCH_ASSOC);
            if(!$records){
                return FALSE;
            }
            return $records;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    /********************************************************************\/
     *                    Evaluate a lecturer                                              *
     ********************************************************************/
    public static function vote($student,$lec,$unit,$rating,$comment){
        try{
            if(self::getError()){
                return FALSE;
            }
            $sql = "INSERT INTO votes(student,rating,lec,unit,evaluation,comment)VALUES(?,?,?,?,?,?)";
            $evaluation = Evaluation::getActive()['id'];
            $qr = self::connect()->prepare($sql);
            $qr->bindParam(1,$student);
            $qr->bindParam(2,$rating);
            $qr->bindParam(3,$lec);
            $qr->bindParam(4,$unit);
            $qr->bindParam(5,$evaluation);
            $qr->bindParam(6,$comment);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            return TRUE;
        } catch (Exception $ex){
            return false;
        }
    }
    /**********************************************************************
     * Looks like a duplicated code for checking units already evaluated
     ************************************************************************/
    public static function getAlreadyVoted($id,$evaluation,$unit){
        try{
            $sql = "SELECT * FROM donesvote WHERE student=? AND evaluation=? AND unit=?";
            if(Evaluation::getActive() && Evaluation::getActive()==10) {
                $evaluation = Evaluation::getActive()['id'];
            }
            if(self::getError()){
                return FALSE;
            }
            $cn = self::connect();
            $qr = $cn->prepare($sql);
            $qr->bindParam(1,$id);
            $qr->bindParam(2,$evaluation);
            $qr->bindParam(3,$unit);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            $records = $qr->fetchAll(PDO::FETCH_ASSOC);
            return $records;
        }catch (Exception $ex){
            return FALSE;
        }
    }
    /***********************************************************
     * Make sure an evaluation of a lecturer is marked to avoid redoing it
     ***********************************************************/
    public static function markAsAlreadyVoted($id,$unit){
        try{
            $sql = "INSERT INTO donesvote(student,evaluation,unit)VALUES(?,?,?)";
            if(self::getError()){
                return FALSE;
            }
            $cn = self::connect();
            $qr = $cn->prepare($sql);
            $evalution = Evaluation::getActive()['id'];
            $qr->bindParam(1,$id);
            $qr->bindParam(2,$evalution);
            $qr->bindParam(3,$unit);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            return TRUE;
        }catch (Exception $ex){
            return FALSE;
        }
    }
    /****************************************************************
     * Get a list of lecturers you already evaluated
     ***************************************************************/
    public static function getMyDoneVoted($id){
        try{
            $sql = "SELECT * FROM donesvote WHERE student=? AND evaluation = ?";
            if(self::getError()){
                return FALSE;
            }
            $qr = self::connect()->prepare($sql);
            $evaluation = Evaluation::getActive()['id'];
            $qr->bindParam(1,$id);
            $qr->bindParam(2,$evaluation);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            $records = $qr->fetchAll(PDO::FETCH_ASSOC);
            if(!$records){
                return FALSE;
            }
            return $records;
            
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    /***********************************************************************************
     * Check if I already filled a form for a unit and make sure you don't refil it again
     ***********************************************************************************/
    public static function alreadyVotedThis($unit,$student){
        try{
            $voted = self::getMyDoneVoted($student);
            //print_r($voted);
            if(!$voted){
                return FALSE;
            }
            $evaluation = Evaluation::getActive()['id'];
            foreach ($voted as $voten){
                if($voten['unit']==$unit && $voten['evaluation']==$evaluation && $voten['student']==$student){
                    return TRUE;
                }
            }
            return FALSE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    /********************************************************************
     * Pull out a list of my lecturers who have not already ben evaluated
     ********************************************************************/
    public static function getNotVoted($sem,$year,$course){
        try{
            $units = self::getMyUnits($course, $year, $sem);
            $res = Array();
            if(!$units){
                return FALSE;
            }
            if(count($units)==0){
                return FALSE;
            }
            //print_r($units);
            foreach ($units as $unit){
               if(!self::alreadyVotedThis($unit['id'], $_SESSION['student']['id'])){
                        array_push($res, $unit);
                    }
             }
             if(count($res)==0){
                 return FALSE;
             }
             return $res;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    /************************************************************
     *
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     *  Code for the schools
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     *****************************************************************/
    public static function getAllSchools(){
        try{
            $sql = "SELECT * FROM schools ORDER BY id asc";
            if(self::getError()){
                return FALSE;
            }
            $qr = self::connect()->prepare($sql);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            $records = $qr->fetchAll(PDO::FETCH_ASSOC);
            if(!$records){
                return FALSE;
            }
            return $records;
        } catch (Exception $e) {
            return FALSE;
        }
    }
    /*****************
     * Add a new school
     */
    public static function addSchools($name,$description){
        try{
            $sql = "INSERT INTO schools(title,about)VALUES(?,?)";
            if(self::getError()){
                return FALSE;
            }
            $qr = self::connect()->prepare($sql);
            $qr->bindParam(1,$name);
            $qr->bindParam(2,$description);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            return TRUE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    public static function addCourse($title,$school,$department,$description){
        try{
            $sql = "INSERT INTO courses(title,school,department,description)VALUE(?,?,?,?)";
            if(self::getError()){
                return FALSE;
            }
            $qr = self::connect()->prepare($sql);
            $qr->bindParam(1,$title);
            $qr->bindParam(2,$school);
            $qr->bindParam(3,$department);
            $qr->bindParam(4,$description);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            return TRUE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    public static function getDepartment(){
        try{
            $sql = "SELECT * FROM departments ORDER BY id asc";
            if(self::getError()){
                return FALSE;
            }
            $qr = self::connect()->prepare($sql);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            $records = $qr->fetchAll(PDO::FETCH_ASSOC);
            if(!$records){
                return FALSE;
            }
            return $records;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public static function getDepartmentSchool($department) {
        try{
            $sql = "SELECT school FROM departments WHERE id = ?";
            if(self::getError()){
                return FALSE;
            }
            $qr = self::connect()->prepare($sql);
            $qr->bindParam(1,$department);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            $records =  $qr->fetchAll(PDO::FETCH_ASSOC);
            if(!$records){
                return FALSE;
            }
            return $records;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public static function getByID($id) {
        try{
            $records = self::getAllStudents();
            if(!$records){
                return FALSE;
            }
            foreach ($records as $record){
                if($record['id']==$id){
                    return $record;
                }
            }
            return FALSE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
     public static function updateStudent($id,$regno,$names,$password,$course,$year,$semester,$gender,$insession){
        try{
            if(self::getError()) return false;
            $cn = self::connect();
            $sql ="UPDATE students SET regno=?,names=?,password=?,course=?,year=?,sem=?,gender=?,courselevel=?,insession=? WHERE id=?";
            $qr = $cn->prepare($sql);
            $qr->bindParam(1,$regno);
            $password = sha1($password);
            $qr->bindParam(2,$names);
            $qr->bindParam(3,$password);
            $qr->bindParam(4,$course);
            $qr->bindParam(5,$year);
            $qr->bindParam(6,$semester);
            $qr->bindParam(7,$gender);
            $qr->bindParam(8,$courselevel);
            $qr->bindParam(9,$insession);
            $qr->bindParam(10,$id);
            if(!$qr)return false;
            $qr->execute();
            return true;
        }catch (Exception $ex){
            //print_r($ex);
            return false;
        }
    }
    public static function changePass($id,$currentPass,$newpass){
        $exem = null;
        try{
            if(self::getError()) return false;
            $newpass = sha1($newpass);
            $sql = "UPDATE students SET password=? WHERE id=?";
            $cn = self::connect();
            $qr = $cn->prepare($sql);
            $qr->bindParam(1,$newpass);
            $qr->bindParam(2,$id);
            if (!$qr) {
                return false;
            }
            $qr->execute();
            return true;
        } catch (Exception $ex) {
            $exem = $ex->getMessage();
            //print_r($exem);
            return false;
        }
    }
     public static function alreadySigned($student,$schedule){
        try{
            $year = date("Y");
            $class = Schedules::getClassFromSchedule($schedule);
            if(!$class){
              return FALSE;
            }
            $class = $class[0]['id'];
            $sql = "SELECT * FROM attendance WHERE class=? AND student=? and year_attended=?";
            $qr = self::connect()->prepare($sql);
            $qr->bindParam(1,$class);
            $qr->bindParam(2,$student);
            $qr->bindParam(3,$year);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            $records = $qr->fetchAll(PDO::FETCH_ASSOC);
            if($records){
                return TRUE;
            }
            return FALSE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

}