<?php
abstract class Admin extends DB {
        public static function changePass($id,$currentPass,$newpass){
        $exem = null;
        try{
            if(self::getError()) return false;
            $newpass = sha1($newpass);
            $sql = "UPDATE admins SET password=? WHERE id=?";
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
