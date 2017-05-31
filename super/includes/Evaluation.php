<?php
class Evaluation extends DB{
    public static function getEvaluations($json=false){
        try{
            if(self::getError()) return false;
            $cn = self::connect();
            $sql ="SELECT * FROM surveys ORDER BY id desc LIMIT 20";
            $qr = $cn->prepare($sql);
            if(!$qr) return false;
            $qr->execute();
            $records = $qr->fetchAll(PDO::FETCH_ASSOC);
            if (!$records) {
                return [];
            }
            return $records;
        }catch (Exception $ex){
            print_r($ex->getMessage());
            return false;
        }
    }
    public static function getActive(){
        try{
            $date = date("Y-m-d");
            if(!self::getEvaluations()){
              return FALSE;   
            }
            $founds = self::getEvaluations();
            if(!$founds){
                return FALSE;
            }
            foreach($founds as $found){
                if($found['status']==1 && $found['enddate']>=$date){
                    return $found;
                }
            }
            return FALSE;
        }catch (Exception $ex){
            //print_r($ex);
            return false;
        }
    }
    public static function stopAllOthers(){
        try{
            if(self::getError()) return false;
            $cn = self::connect();
            $sql = "UPDATE surveys SET status=0 WHERE status=1";
            $qr = $cn->prepare($sql);
            if(!$qr) return false;
            $qr->execute();
            return true;
        }catch (Exception $ex){
            return false;
        }
    }
    public static function startEvaluation($end){
        try{
            $sql = "INSERT INTO surveys(startdate,enddate,status)VALUES(?,?,?)";
            if(self::getError()) return false;
            $cn = self::connect();
            $qr = $cn->prepare($sql);
            $today = date("Y-m-d");
            $stat = 1;
            $qr->bindParam(1,$today);
            $qr->bindParam(2,$end);
            $qr->bindParam(3,$stat);
            if(!$qr) return false;
            $qr->execute();
            return true;
        }catch (Exception $ex){
            // print_r($ex->getMessage());
            return false;
        }
    }
    public static function clearQuestions($evaluation){
        try {
            $sql = "DELETE  FROM questions WHERE questions.survey=?";
            if (self::getError()) return false;
            $cn = self::connect();
            $qr = $cn->prepare($sql);
            $qr->bindParam(1, $evaluation);
            if (!$qr) {
                return false;
            }
            $qr->execute();
            return true;
        }catch (Exception $ex){
            return false;
        }
    }
    public static function currentQuestions(){
        try{
            $sql = "SELECT * FROM questions where survey=?";
            if(self::getError()){
                return FALSE;
            }
            $eva = self::getActive();
            if(!$eva){
                return FALSE;
            }
            $eva1 = $eva['id'];
            $qr = self::connect()->prepare($sql);
            
            $qr->bindParam(1,$eva1);
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
    public static function getByID($id){
        try{
            $records = self::getEvaluations();
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

}