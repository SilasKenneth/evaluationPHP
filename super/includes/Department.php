<?php
abstract class Department extends DB{
    public static function getAllDepartments(){
        try {
            if (self::getError()) {
                return false;
            }
            $cn = self::connect();
            $sql = "SELECT * FROM departments ORDER BY id asc";
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
        } catch (Exception $ex) {
            return false;
        }
    }
    public static function addDepartment($school,$name){
        $exem = null;
        try {
            if (self::getError()) {
                return false;
            }
            $cn = self::connect();
         $sql = "INSERT INTO departments(school,name)VALUES(?,?)";
         $qr = $cn->prepare($sql);
         $qr->bindParam(1,$school);
         $qr->bindParam(2,$name);
         if (!$qr) {
                return false;
            }
            $qr->execute();
         return true;
        } catch (Exception $ex) {
            $exem = $ex->getMessage();
            return false;
        }
    }
    public static function deleteDepartment($id){
        $exem = null;
        try {
            if (self::getError()) {
                return false;
            }
            $cn = self::connect();
            $sql = "DELETE FROM departments WHERE id=?";
            $qr = $cn->prepare($sql);
            $qr->bindParam(1,$id);
            if (!$qr) {
                return false;
            }
            $qr->execute();
            return true;
        } catch (Exception $ex) {
            $exem = $ex->getMessage();
            return false;
        }
    }
    public static function getLastInsert(){
        try{
           if(self::getError()){
                return FALSE;
            }
            $sql = "SELECT MAX(id) as big FROM hod";
            $qr1 = self::connect()->prepare($sql);
            if(!$qr1){
                return FALSE;
            }
            $qr1->execute();
            $rec = $qr1->fetchAll(PDO::FETCH_ASSOC);
            if(!$rec){
                return FALSE;
            }
            return $rec[0]['big'];
        } catch (Exception $ex) {
            return FALSE;
        }
    }
     public static function updateDepartment($id){
        try{
           $rec = self::getLastInsert();
            if(!$rec){
                return FALSE;
            }
            $ids = $rec;
            $sql1 = "UPDATE departments SET hod=? WHERE id=?";
            $qr = self::connect()->prepare($sql1);
            $qr->bindParam(1,$ids);
            $qr->bindParam(2,$id);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            return TRUE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    public static function updateCourses($id){
        try{
            $sql = "UPDATE hod SET department=0 WHERE department=? AND NOT id=?";
            $ex = self::getLastInsert();
            if(!$ex){
                return FALSE;
            }
            if(self::getError()){
                return FALSE;
            }
            $qr = self::connect()->prepare($sql);
        
            $qr->bindParam(1,$id);
            $qr->bindParam(2, $ex);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            return TRUE;
        } catch (Exception $ex) {
            //print_r($ex);
            return FALSE;
        }
    }
        public static function getById($id){
        try{
            $sql = "SELECT name FROM departments WHERE id=?";
            if(self::getError()){
                return FALSE;
            }
            $qr = self::connect()->prepare($sql);
            $qr->bindParam(1,$id);
            if(!$qr){
                return FALSE;
            }
            $qr->execute();
            $record = $qr->fetchAll(PDO::FETCH_ASSOC);
            if(!$record){
                return FALSE;
            }
            return $record[0]['name'];
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    public static function getAllSchools(){
         try {
            if (self::getError()) {
                return false;
            }
            $cn = self::connect();
            $sql = "SELECT * FROM schools ORDER BY id asc";
            $qr = $cn->prepare($sql);
            if (!$qr) {
                return false;
            }
            $qr->execute();
            $records = $qr->fetchAll(PDO::FETCH_ASSOC);
            if (!$records) {
                return FALSE;
            }
            return $records;
        } catch (Exception $ex) {
            return false;
        }
    }
}