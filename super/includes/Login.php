<?php
//require_once  "DB.php";
abstract class Login extends DB{
	/*
	*****************************************************
	  checkCreds($param)
	  Get user details from the table specified by the $user parameter
	  and return the associative array incase something went wrong just return false

	  Remember to catch as many errors as possible
	*****************************************************
	*/
    private static function checkCreds($user){
        try{
            $sql = "SELECT * FROM ".$user.";";
            $cn = self::connect();
            if (self::getError() > 0) {
                return false;
            }
            $qr = $cn->prepare($sql);
            if(!$qr) return false;
            $qr->execute();
            $data = $qr->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }catch (Exception $ex){
            return false;
        }
    }
    /****************************************************
       getByField()
       ***************************
       Get a single user from the user Object and return it based on the provided values for
       $value and $passvalue respectively
       Incase there doesnt exist anything like that or there was a problem connecting to the DB
       WE RETURN FALSE

       Remember to catch as many errors as you can
    ******************************************************/
    private static function getByField($user,$username,$password,$value,$passvalue){
        try{
            $pass = sha1($passvalue);
            $data = self::checkCreds($user);
            $res = [];
            if(!$data) return false;
            $found = false;
            foreach ($data as $datum){
                if(!array_key_exists($username,$datum) || !array_key_exists($password,$datum)){
                    return false;
                }
                if($datum[$username]==$value && $datum[$password]==$pass){
                    array_push($res,$datum);
                    $found = true;
                    break;
                }

            }
            if(!$found){
                return false;
            }
            //print_r($data);
            return $res;
        }catch(Exception $ex){
            return false;
        }
    }
    /**********************************************************

    *********************************************************/
    public static function student($username,$password){
        try{
            $data = self::getByField("students","regno","password",$username,$password);
            if(!$data) return false;
            $data = $data[0];
            $password = sha1($password);
            if($username!=$data['regno'] || $password!=$data['password']){
                return false;
            }

            return $data;
        }catch (Exception $ex){
            return false;
        }
    }
    public static function lecturer($username,$password){
        try{
            $data = self::getByField("lecturers","email","password",$username,$password);
            if (!$data) {
                return false;
            }
            $data = $data[0];
            $password = sha1($password);
            if($username!=$data['email'] || $password!=$data['password']){
                return false;
            }
            if($data['status']==0){
                return FALSE;
            }
            return $data;
        }catch (Exception $ex){
            print_r($ex);
            return false;
        }
    }
    public static function admin($username,$password){
        try{
            $data = self::getByField("admins","email","password",$username,$password);
            if(!$data) return false;
            $data = $data[0];
            $password = sha1($password);
            if($username!=$data['email'] || $password!=$data['password']){
                return false;
            }

            return $data;
        }catch (Exception $ex){
            return false;
        }
    }
    public static function hod($username,$password){
        try{
            $data = self::getByField("hod","email","password",$username,$password);
            if(!$data) return false;
            $data = $data[0];
            $password = sha1($password);
            if($username!=$data['email'] || $password!=$data['password']){
                return false;
            }
            return $data;
        }catch (Exception $ex){
            return false;
        }
    }

}
?>

