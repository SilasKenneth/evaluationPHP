<?php
//require_once "Settings.php";
 abstract class DB extends Settings{
     // Constants to store database settings and object
     private static $conn = false;
     private static $USERNAME = null;
     private static $DB_OPTIONS = array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
     private static $errors = array();
     private static $CONFIG_FOLDER = 'config';
     private static $CONFIG_FILE = 'config.ini';
     //Get database configurations from the config.ini on the config folder
      private static $sets = array("username","password","dbname","host");
     /*********************************************
        getConfig($param,$param1)
     ************************************************
      This is where the database configuration file located at the /config/ folder
      is read and values from it parsed
     */
     private static function getConfig($folder,$filename){
       $ini_object = false;
       $settings = false;
       //TODO
         /*  Remodify this PATH */
       /*
         This is where we set the path to the configuration file $path;
       */
       $path = $folder.DIRECTORY_SEPARATOR.$filename;
         try{
           //First check if the configurations file exist and open for reading
           if(file_exists($path)){
               $ini_object = parse_ini_file($path,true);
               if($ini_object==null || count($ini_object)==0){
                 return false;
               }

               //Check if the required fields on the settings file all exist
              if(count($ini_object)<4){
                 return false;
              }
           }
           if(!$ini_object) return false;
           $settings = $ini_object;
           $set = array_keys($settings);
           if(!self::allInArray($set,self::$sets)){
             return false;
           }
           return $settings;
           /*******************************************************
            Make sure you dont expose bugs to everyone actually catch them before they reach your user
           ******************************************************/
         }catch(Exception $ex){
            return false;
         }
     }
     /*
     *********************************
                   getError()
     ********************************
       This is where we check for errors incase there is a missing configuration we return 1 otherwise
       if there is a problem just connecting with the database then we return 2

       Incase no error occurs we return ZERO
     */
     public static function getError(){
       $cfd = self::$CONFIG_FOLDER;
       $cfs = self::$CONFIG_FILE;
       if(!self::getConfig($cfd,$cfs)){
         return 1;
       }
       if(!self::connect()){
         return 2;
       }
       return 0;
     }
     /***************************************************
             connect()
     **************************************************
       This is where the actual connection to the database is initiated and return the connection
       Object incase we successfully connected otherwise return false
       We do this so we dont get unexpected behaviour whenever we encounter a bug so no user actualy knows we have
       bug in our code.
     */
     public static function connect(){
       try {
         if(self::getConfig(self::$CONFIG_FOLDER,self::$CONFIG_FILE)==false){
           return false;
         }
         $cfd = self::$CONFIG_FOLDER;
         $cfs = self::$CONFIG_FILE;
         $cons = self::getConfig($cfd,$cfs);
         self::$conn = new PDO("mysql:host=".$cons['host'].';dbname='.$cons['dbname'].';',$cons['username'],$cons['password'],self::$DB_OPTIONS);
         return self::$conn;
       } catch (PDOException $e) {
           //print_r($e->getMessage());
         return false;
       }

     }
 }
 ?>
