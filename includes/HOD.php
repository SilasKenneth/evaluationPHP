<?php
abstract class HOD extends DB implements Serializable {
    public static function getCourses(){
        try{
            $sql = "SELECT * FROM courses";
            if(self::getError()){
                return FALSE;
            }
            $qr = self::connect()->prepare($sql);
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
    public static function getDepartmentCourses($department){
        try{
            $sql = "SELECT * FROM courses WHERE department=?";
            if(self::getError()){
                return FALSE;
            }
            $qr = self::connect()->prepare($sql);
            $qr->bindParam(1,$department);
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
    public static function getLecturersByDepartments($department){
        try{
            $sql = "SELECT DISTINCT(lecturers.id),lecturers.fullnames,lecturers.idnumber,lecturers.email FROM lecturers INNER JOIN units ON units.lecturer = lecturers.id WHERE units.course IN (SELECT courses.id FROM courses WHERE courses.department=?)";
            if(self::getError()){
                return FALSE;
            }
            $qr = self::connect()->prepare($sql);
            $qr->bindParam(1,$department);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            $records = $qr->fetchAll(PDO::FETCH_ASSOC);
            return $records;
        } catch (Exception $ex) {
            print_r($ex);
            return FALSE;
        }
    }
    public static function checkAvailable($dept,$id){
        try{
            if(!self::getLecturersByDepartments($dept)){
                return FALSE;
            }
            $res = [];
            $records = self::getLecturersByDepartments($dept);
            foreach ($records as $record){
                if($record['id']==$id){
                    return $record;
                }
            }
            return $res;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    public static function getDepartmentUnits($department){
        try{
            $sql = "SELECT DISTINCT(units.id),units.title,units.lecturer,units.course,units.code FROM units INNER JOIN courses ON courses.id=units.course WHERE courses.department=?";
            if(self::getError()){
                return FALSE;
            }
            $qr = self::connect()->prepare($sql);
            $qr->bindParam(1,$department);
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
    public static function inDepartmentUnits($department,$id){
        try{
            $records = self::getDepartmentUnits($department);
            if(!$records){
                return FALSE;
            }
            foreach ($records as $record){
               if($record['id']==$id){
                return TRUE;
               }
            }
            return FALSE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public static function getDepartmentResults($dept,$evaluation){
        try{
            $records = Statistics::getAllRatingsByEvaluation($evaluation);
            if(!$records){
                return FALSE;
            }
            $res = [];
            foreach ($records as $record){
                if(self::inDepartmentUnits($dept, $record['unit'])){
                    array_push($res, $record);
                }
            }
            return $res;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
   public static function AddNew($fullnames,$email,$department,$password){
        try{
            $username = explode("@", $email)[0];
            $sql = "INSERT INTO hod(fullnames,email,department,password,username)VALUES(?,?,?,?,?)";
            if(self::getError()){
                return FALSE;
            }
            $qr = self::connect()->prepare($sql);
            $qr->bindParam(1,$fullnames);
            $qr->bindParam(2,$email);
            $qr->bindParam(3,$department);
            $qr->bindParam(4,$password);
            $qr->bindParam(5,$username);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            return TRUE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public static function getCourseByID($luc) {
        try{
            $sql = "SELECT * FROM courses WHERE id=?";
            $qr = self::connect()->prepare($sql);
            $qr->bindParam(1,$luc);
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
    public static function changePass($id,$currentPass,$newpass){
        $exem = null;
        try{
            if(self::getError()) return false;
            $newpass = sha1($newpass);
            $sql = "UPDATE hod SET password=? WHERE id=?";
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

}