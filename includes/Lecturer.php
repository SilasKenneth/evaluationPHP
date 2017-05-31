<?php
class Lecturer extends DB{
    public static function addLecturer($name, $id, $email, $password){
        try {
              $sql = "INSERT INTO lecturers(idnumber,fullnames,email,password,status)VALUES(?,?,?,?,?)";
              if(self::getError()){
                  return false;
              }
              $status = 1;
              $password = sha1($password);
              $cn = self::connect();
              $qr = $cn->prepare($sql);
              $qr->bindParam(1,$id);
              $qr->bindParam(2,$name);
              $qr->bindParam(3,$email);
              $qr->bindParam(4,$password);
              $qr->bindParam(5,$status);
              if(!$qr){
                  return false;
              }
              $qr->execute();
              return true;
        } catch (Exception $ex) {
          return false;  
        }
    }
    public static function getAllLecturers(){
        try{
            if (self::getError()) {
                return false;
            }
            $cn = self::connect();
            $sql = "SELECT * FROM lecturers  ORDER BY id asc";
            $qr = $cn->prepare($sql);
            if(!$qr) return false;
            $qr->execute();
            $records =$qr->fetchAll(PDO::FETCH_ASSOC);
            if (!$records) {
                return 10;
            }
            return $records;
        }catch (Exception $ex){
            return false;
        }
    }
    public static function myUnits($id){
        try{
            $units = Units::getAllUnits();
            if(!$units) return false;
            $res = [];
            foreach ($units as $unit){
                if($unit['lecturer']==$id){
                    array_push($res,$unit);
                }
            }
            if(!$res) return 10;
            return $res;
        }catch(Exception $ex){
            return false;
        }
    }
    public static function myTodaySchedules($id){
        try{
            $day = strftime("%w");
            $sql = "SELECT units.code,units.lecturer,units.id as unit,schedules.days,units.title,schedules.id,schedules.begintime,schedules.endtime FROM schedules INNER JOIN units on schedules.unit=units.id WHERE units.lecturer=? and days=?";
            if(self::getError()){
                return FALSE;
            }
            $qr = self::connect()->prepare($sql);
            $qr->bindParam(2,$day);
            $qr->bindParam(1,$id);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            $records = $qr->fetchAll(PDO::FETCH_ASSOC);
            if(!$records){
                return FALSE;
            }
            return $records;
        }catch (Exception $ex){
            return FALSE;
        }
    }
    public static function myStudents($lecturer){
        try{
           $sql = "SELECT DISTINCT(students.id),students.names,students.regno,units.id as unit, students.year, students.sem, students.course FROM students INNER join units ON units.course = students.course WHERE units.year = students.year and units.semester=students.sem and units.lecturer=?";
           if(self::getError()){
               return FALSE;
           }
           $qr = self::connect()->prepare($sql);
           $qr->bindParam(1,$lecturer);
           if(!$qr){
               return FALSE;
           }
           $qr->execute();
           $records = $qr->fetchAll(PDO::FETCH_ASSOC);
//           print_r($records);
           if(!$records){
               return FALSE;
           }
           return $records;
        }catch(Exception $ex){
            return FALSE;
        }
    }
    public static function getStudentsByUnit($lecturer,$unit){
        try{
            if(!self::myStudents($lecturer)){
                return FALSE;
            }
            $res = [];
            $students = self::myStudents($lecturer);
            foreach($students as $student){
                if($student['unit']==$unit){
                    array_push($res, $student);
                }
            }
            return $res;
        } catch (Exception $ex) {

        }
    }
    public static function confirmAttendance($student){
        try{

        }catch (Exception $ex){
            return false;
        }
    }
    public static function getActive(){
        try{
            $lecs = self::getAllLecturers();
            if(!$lecs){
                return FALSE;
            }
            if($lecs==10){
                return 10;
            }
            $res = [];
            foreach ($lecs as $lec) {
                if($lec['status']==1){
                    array_push($res, $lec);
                }
            }
            if(!$res){
                return 10;
            }
            return $res;
        } catch (Exception $ex) {

        }
    }
    public static function discontinue($id){
 try{
            $sql = "UPDATE lecturers SET status=0 WHERE id=?";
            if(self::getError()){
                return FALSE;
            }
            $cn = self::connect();
            $qr = $cn->prepare($sql);
            $qr->bindParam(1,$id);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            return TRUE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public static function getById($record) {
        try{
            if(!self::getAllLecturers()){
                return FALSE;
            }
            $lec = self::getAllLecturers();
            foreach ($lec as $l){
                if($l['id']==$record){
                    return $l;
                }
            }
            return FALSE;
        } catch (Exception $ex) {
            return FALSE;
        }
        
    }
    public static function checkAvailable($id){
        try{
            $lecturers = self::getAllLecturers();
            if(!$lecturers){
                return FALSE;
            }
            if($lecturers==10){
                return FALSE;
            }
            foreach($lecturers as $lecturer){
                if($lecturer['id']==$id){
                    return $lecturer;
                }
            }
            return FALSE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    public static function updateLecturer($id,$idnumber,$name,$email,$password,$status){
        try{
            $sql = "UPDATE lecturers SET idnumber=? ,fullnames=?,email=?,password=?,status=? WHERE id=?";
            if(self::getError()){
                return FALSE;
            }
            $qr = self::connect()->prepare($sql);
            $qr->bindParam(1,$idnumber);
            $qr->bindParam(2,$name);
            $qr->bindParam(3,$email);
            $qr->bindParam(4,$password);
            $qr->bindParam(5,$status);
            $qr->bindParam(6,$id);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            return TRUE;
            
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    public static function recommend($lecturer,$unit,$evaluation,$content){
        try{
            $sql = "INSERT INTO recommendations(lecturer,unit,evaluation,content)VALUES(?,?,?,?)";
            if(self::getError()){
                return FALSE;
            }
            $qr = self::connect()->prepare($sql);
            $qr->bindParam(1,$lecturer);
            $qr->bindParam(2,$unit);
            $qr->bindParam(3,$evaluation);
            $qr->bindParam(4,$content);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            return TRUE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    public static function changePass($id,$currentPass,$newpass){
        $exem = null;
        try{
            if(self::getError()) return false;
            $newpass = sha1($newpass);
            $sql = "UPDATE lecturers SET password=? WHERE id=?";
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
            print_r($exem);
            return false;
        }
    }

}