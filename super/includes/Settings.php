<?php
 define('BASE_PATH','/');
 abstract class Settings{
   public static function getDayName($day){
      $days = ['Monday','Tuesday','Wednesday','Thursday','Friday'];
      try{
          if($day>5 || $day<1){
              return FALSE;
          }
          return $days[$day-1];
      } catch (Exception $ex) {
          return FALSE;
      }
   }
   public static function allInArray($arr, $seed){
     sort($arr);
     sort($seed);
     return $seed==$arr;
   }
   //TODO complete the login validation function();
   public static function makeSureUserIsLoggedIn($module,$redirect_to){
      try{
        $module = strtolower($module);
        if(!isset($_SESSION[$module])){
            header("location:".$redirect_to);
            return FALSE;
        }
        return TRUE;
      }catch(Exception $ex){
          return FALSE;
      }
   }
   public static function isEmpty($fields){
   	try{
               if (count($fields) == 0) {
                return false;
            }
            foreach($fields as $field){
                if (trim($field) == "") {
                    return false;
                }
            }
   		return true;
   	}catch(Exception $ex){
   		return false;
   	}
   }
   public static function validateLength($var,$min,$max,$message){
   	 try {
   	 	$var = (string)$var;
   	 	$len = strlen($var);
   	 	if ($len < $min || $len > $max) {
                return $message;
            }
            return 10;
   	 } catch (Exception $e) {
   	 	return false;
   	 }
   }

public static function formatdate($date){
    try{
        $res = NULL;
        $ans = NULL;
        if($date){
            $res = explode("-", $date);
            if(sizeof($res)<3){
                return FALSE;
            }
//            //print_r($res);
//            $tmp = $res[1];
//            $res[1] = $res[2];
//            $res[2] = $tmp;
//            //print_r($res);
            $res = implode("-",$res);
            $res = date_create($res);
        }
        if($res){
            $ans = date_format($res,'jS F Y' );
        }
        //$dates = date_format($date, 'l jS F Y');
        if($ans){
            return $ans;
        }
       return FALSE;
    } catch (Exception $ex) {
        return FALSE;
    }
}
}

