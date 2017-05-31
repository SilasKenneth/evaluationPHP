<?php
 abstract class PageHelper{
   public static function pageExists($filename){
     return file_exists($filename);
   }
   public static function render($page){
      if(self::pageExists($page)) {
         include_once($page);
         return true;
      }
      return false;
   }
 }
 ?>
