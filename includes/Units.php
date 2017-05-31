<?php

abstract class Units extends DB{
    public static function addUnit($year,$course,$semester,$title,$description,$lecturer, $status){
        try{
            if(self::getError()){
                return FALSE;
            }
            $cn = self::connect();
            $sql = "INSERT INTO units(year,course,semester,title,description,lecturer,status)VALUES(?,?,?,?,?,?,?)";
            $status = 0;
            $lecturer = 0;
            $qr = $cn->prepare($sql);
            $qr->bindParam(1,$year);
            $qr->bindParam(2,$course);
            $qr->bindParam(3,$semester);
            $qr->bindParam(4,$title);
            $qr->bindParam(5,$description);
            $qr->bindParam(6,$lecturer);
            $qr->bindParam(7,$status);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            return TRUE;
        } catch (Exception $ex) {

        }
    }
    public static function assignUnits($lecturer,$unit){
        try {
            $sql = "UPDATE units SET lecturer=? WHERE id=?";
            if(self::getError()){
                return FALSE;
            }
            $cn = self::connect();
            $qr = $cn->prepare($sql);
            $qr->bindParam(1,$lecturer);
            $qr->bindParam(2,$unit);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            return TRUE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public static function getAllUnits(){
        try{
            if (self::getError()) {
                return false;
            }
            $cn = self::connect();
            $sql ="SELECT * FROM units";
            $qr = $cn->prepare($sql);
            if (!$qr) {
                return false;
            }
            $qr->execute();
            $records = $qr->fetchAll(PDO::FETCH_ASSOC);
            if (!$records) {
                return 10;
            }
            return $records;
        }catch (Exception $ex){
            return false;
        }
    }
    public static function getUnitDetails($id){
        try{
            $units = self::getAllUnits();
            if(!$units){
                return FALSE;
            }
            foreach ($units as $unit){
                if($unit['id']==$id){
                    return $unit;
                }
            }
            return FALSE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    public static function getUnitsByClass($course,$year,$semester){
        try{
            if (!self::getAllUnits()) {
                return false;
            }
            $units = self::getAllUnits();
            if (count($units) < 1) {
                return false;
            }
            $res = [];
            foreach ($units as $unit){
                if($unit['course']==$course && $unit['year']==$year && $unit['semester']==$semester){
                    array_push($res,$unit);
                }
            }
            if (!$res) {
                return false;
            }
            return $res;
        }catch (Exception $ex){
            return false;
        }
    }
    public static function getUnassignedUnits(){
        try{
            if(!self::getAllUnits()){
                return FALSE;
            }
            $units = self::getAllUnits();
            if(count($units)<1){
                return 10;
            }
            $res = [];
            foreach ($units as $unit){
                if($unit['lecturer']==0){
                    array_push($res, $unit);
                }
            }
            if(!$res){
                return 10;
            }
            return $res;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    public static function discontinueUnits($lecturer){
        try{
            $sql = "UPDATE units SET lecturer=0 WHERE lecturer=?";
            if(self::getError()){
                return FALSE;
            }
            $cn = self::connect();
            $qr = $cn->prepare($sql);
            $qr->bindParam(1,$lecturer);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            return TRUE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    public static function getUnitCourse($id){
        try{
            $sql = "SELECT * FROM courses WHERE id=?";
            $res  =[];
           if(self::getError()){
               return FALSE;
           }
           $qr = self::connect()->prepare($sql);
           $qr->bindParam(1,$id);
           if(!$qr){
               return FALSE;
           }
           $qr->execute();
           $units = $qr->fetchAll(PDO::FETCH_ASSOC);
           if(!$units){
               return FALSE;
           }
            foreach ($units as $unit){
                if($unit['id']==$id){
                    return $unit;
                }
            }
            return $res;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    public static function getLecturerUnits($lecturer){
        try{
            $units = self::getAllUnits();
            if(!$units){
                return FALSE;
            }
            $res = [];
            foreach ($units as $unit){
                if($unit['lecturer']==$lecturer){
                    array_push($res, $unit);
                }
            }
            return $res;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

}