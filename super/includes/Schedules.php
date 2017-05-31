<?php
class Schedules extends DB{
    public static function addSchedule($day, $unit, $course,$starttime,$endtime){
       try{
           if (self::getError()) {
                return FALSE;
            }
            if (self::checkClassExists($day, $starttime, $endtime, $course)) {
                return 10;
            }
            $sql = "INSERT INTO schedules(unit,course,days,begintime,endtime)VALUES(?,?,?,?,?)";
           $cn = self::connect();
           $qr = $cn->prepare($sql);
           $qr->bindParam(1,$unit);
           $qr->bindParam(2,$course);
           $qr->bindParam(3,$day);
           $qr->bindParam(4,$starttime);
           $qr->bindParam(5,$endtime);
           if (!$qr) {
                return false;
            }
            $qr->execute();
           return true;
       }catch (Exception $ex){
//           print_r($ex);
           return false;
       }
    }
    public static function checkClassExists($day, $starttime, $endtime, $course){
        try{
            if (self::getError()) {
                return false;
            }
            $cn = self::connect();
            $sql = "SELECT * FROM schedules WHERE days=? AND (starttime>=? AND endtime<=?) AND course=?";
            $qr = $cn->prepare($sql);
            $qr->bindParam(1,$day);
            $qr->bindParam(2,$starttime);
            $qr->bindParam(3,$endtime);
            $qr->bindParam(4,$course);
            if (!$qr) {
                return false;
            }
            $qr->execute();
            $records = $qr->fetchAll(PDO::FETCH_ASSOC);
            if(count($records)==0){
                return array();
            }
            return $records;
        }catch (Exception $ex){
            return false;
        }
    }
    public static function getUnitFromSchedule($id){
        try{
            $sql = "SELECT unit FROM schedules WHERE id=?";
            if(self::getError()){
                return FALSE;
            }
            $qr = self::connect()->prepare($sql);
            $qr->bindParam(1,$id);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            $records = $qr->fetchAll(PDO::FETCH_ASSOC);
            if(!$records){
                return FALSE;
            }
            return $records[0]['unit'];
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    public static function initiateClass($schedule){
        try{
            $date = date("Y-m-d");
            $sql = "INSERT INTO classes(thatdate,schedule)VALUES(?,?)";
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
            return TRUE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    public static function getAlreadyInitiated(){
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
    public static function initiated($id){
        try{
            $date = date("Y-m-d");
            $sql = self::getAlreadyInitiated();
            iF(!$sql){
                return FALSE;
            }
            foreach ($sql as $sqlush){
                if($sqlush['schedule']==$id && $sqlush['thatdate']==$date){
                    return TRUE;
                }
            }
            return FALSE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    public static function checkHasClass($unit){
        try{
            $day = strftime("%w");
            $date = date("Y");
            $sql = "SELECT * FROM schedules WHERE unit=? AND year=? and days=?";
            if(self::getError()){
                return FALSE;
            }
            $qr = self::connect()->prepare($sql);
            $qr->bindParam(1,$unit);
            $qr->bindParam(2,$date);
            $qr->bindParam(3,$day);
            
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            $records = $qr->fetchAll(PDO::FETCH_ASSOC);
            if(count($records)==0){
                return FALSE;
            }
            return TRUE;
        } catch (Exception $ex) {
           // print_r($ex);
            return FALSE;
        }
    }
    public static function getClasses($unit){
        try{
            $year = date("Y");
            $date = date("Y-m-d");
            $sql = "select distinct(schedules.unit),schedules.year, classes.id as number FROM schedules inner join classes on classes.schedule=schedules.id where schedules.unit=? and classes.thatdate=? and schedules.year=?;";
            if(self::getError()){
                return FALSE;
            }
            $qr = self::connect()->prepare($sql);
            $qr->bindParam(1,$unit);
            $qr->bindParam(2,$date);
            $qr->bindParam(3,$year);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            $records = $qr->fetchAll(PDO::FETCH_ASSOC);
            if(!$records){
                return FALSE;
            }
            return $records[0]['number'];
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    public static function getUnconfirmed($unit){
        try{
            $class = self::getClasses($unit);
            if(!$class){
                return FALSE;
            }
            $year = date("Y-m-d");
            $sql = "SELECT DISTINCT(attendance.student) FROM attendance WHERE attendance.class=? AND attendance.confirmed=0 AND attendance.dates=?";
            $qr = self::connect()->prepare($sql);
            $qr->bindParam(1,$class);
            $qr->bindParam(2,$year);
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
            //print_r($ex);
            return FALSE;
        }
    }
    public static function inUnconfirmed($student,$unit){
        try{
            $records = self::getUnconfirmed($unit);
            if(!$records){
                return FALSE;
            }
            foreach ($records as $record){
                if($record['student']==$student){
                    return TRUE;
                }
            }
            return FALSE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    public static function update($student,$unit){
        try{
            $year = date("Y");
            $date = date("Y-m-d");
            $class = self::getClasses($unit);
            $sql = "UPDATE attendance SET confirmed=1 WHERE student=? and class=? and year_attended=? and dates=? and confirmed=0";
            if(self::getError()){
                return FALSE;
            }
            $qr = self::connect()->prepare($sql);
            $qr->bindParam(1,$student);
            $qr->bindParam(2,$class);
            $qr->bindParam(3,$year);
            $qr->bindParam(4,$date);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            return TRUE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    public static function getClassFromSchedule($schedule){
        try{
            $date = date("Y-m-d");
            $year = date("Y");
            $sql = "SELECT classes.id from classes inner join schedules on schedules.id=classes.schedule and schedules.year=? and classes.thatdate=? WHERE classes.schedule=?";
            $qr = self::connect()->prepare($sql);
            $qr->bindParam(1,$year);
            $qr->bindParam(2,$date);
            $qr->bindParam(3,$schedule);
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
//            print_r($ex);
            return FALSE;
        }
    }
}