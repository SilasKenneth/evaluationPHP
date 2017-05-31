<?php
//require_once "DB.php";
  abstract class Statistics extends DB{
      public static $records = null;
      /*
        Get average ratings for lecturers based on the unit and survey
      */
      public static function getLectRatingByCourse($json = false){
          try{
              $sql = "SELECT votes.unit,lecturers.fullnames,units.title,units.code,votes.lec,votes.evaluation,ROUND(AVG(votes.rating),1) as Average FROM units,lecturers,votes INNER JOIN surveys on surveys.id = votes.evaluation WHERE votes.lec = lecturers.id AND units.id = votes.unit GROUP BY votes.lec,votes.unit,votes.evaluation ORDER by votes.lec";
              if(self::getError()!=0) return false;
              else {
                  $qr = self::connect()->prepare($sql);
                  if($qr) {
                      $qr->execute();
                  }else{
                      return false;
                  }
                  $recs = $qr->fetchAll(PDO::FETCH_ASSOC);
                  self::$records = $recs;
                  return $json?json_encode($recs):$recs;
              }
          }catch (PDOException $ex){
              echo $ex->getMessage();
              return false;
          }
      }
      /* Get Ratings for an individual lecturers */
      public static function getLecturerRatings($lecturer){
          try{
              $res = array();
              $ratings = self::getLectRatingByCourse();
              if(!$ratings) return false;
              foreach ($ratings as $rating){
                  if($rating['lec']==(int)$lecturer || $rating['fullnames']==$lecturer) {
                      array_push($res, $rating);
                  }
              }
              return $res;
          }catch (Exception $ex){
              return false;
          }
      }
      /* Get rating of a lecturer for a specific unit */
      public static function getLecturerRatingByUnit($lecturer,$unit){
          try{
              $res = array();
              $ratings = self::getLectRatingByCourse();
              if(!$ratings) return false;
              foreach ($ratings as $rating){
                  if(($rating['lec']==$lecturer || $rating['fullnames']==$lecturer) && ($rating['unit']==$unit || $rating['title']==$unit)){
                      array_push($res,$rating);
                  }
              }
              return $res;
          }catch (Exception $ex){
              return false;
          }
      }
      /* Get ratings by survey */
      public static function getAllRatingsByEvaluation($surveyid)
      {
          try {
              $res = array();
              $ratings = self::getLectRatingByCourse();
              if (!$ratings) return false;
              foreach ($ratings as $rating) {
                  if ($rating['evaluation'] == (int)$surveyid) {
                      array_push($res, $rating);
                  }
              }
              return $res;
          } catch (Exception $ex) {
              return false;
          }
      }
      
      public static function getAllRatingsByEvaluationLec($surveyid,$lec)
      {
          try {
              $res = array();
              $ratings = self::getLectRatingByCourse();
              if (!$ratings) return false;
              foreach ($ratings as $rating) {
                  if ($rating['evaluation'] == (int)$surveyid && $rating['lec']==$lec) {
                      array_push($res, $rating);
                  }
              }
              return $res;
          } catch (Exception $ex) {
              return false;
          }
      }
      
      private static function swap($i,$j,$arr){
          try{
              $tmp = $arr[$i];
              $arr[$i] = $arr[$j];
              $arr[$j] = $tmp;
              return $arr;
          }catch (Exception $ex){
              return false;
          }
      }
      public static function sortByEvaluation($lecturer, $asc = true){
          $lect = self::getLecturerRatings($lecturer);
          //print_r(self::swap(0,1,$lect));
          if(!$lect) return false;
          for($i=0;$i<count($lect);$i++){
              for($j=$i+1;$j<count($lect);$j++){
                      if ($lect[$i]['evaluation'] > $lect[$j]['evaluation']) {
                          $lect = self::swap($i, $j, $lect);
                      }
              }
          }
          if(!$asc){
              $lect = array_reverse($lect);
          }
          return $lect;
      }
      /*Find out if a lecturer deteriorated in rating */
      public static function checkDeter($lecturer){
          try{
              $lect =  self::sortByEvaluation($lecturer);
              if(!$lect) return -1;
              if(count($lect)==1) return false;
              for($i=1;$i<count($lect);$i++){
                  if($lect[$i]['Average']<$lect[$i-1]['Average']) return true;
              }
              return false;
          }catch (Exception $ex){
              return false;
          }
      }
      /* Check all deteriorated lecturers */
      public static function findAllDeters(){
          try{
              $lecturers = self::getLectRatingByCourse();
              if(!$lecturers) return false;
              $res = [];
              foreach ($lecturers as $lect){
                  if(self::checkDeter($lect['lec'])){
                      array_push($res,$lect);
                  }
              }
              return $res;
          }catch (Exception $ex){
              return false;
          }
      }
      public static function countAllClasses(){
          try{
              $sql = "SELECT units.id,schedules.year as academic,units.year,units.semester,units.course,units.title,count(classes.id) as total FROM units,classes INNER JOIN schedules ON classes.schedule=schedules.id   WHERE schedules.unit=units.id GROUP BY units.id,schedules.year;";
              if(self::getError()){
                  return FALSE;
              }
              $qr = self::connect()->prepare($sql);
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
      public static function countByUnit($unit,$year){
          try{
              $records = self::countAllClasses();
              if(!$records){
                  return FALSE;
              }
              
              foreach ($records as $record){
                  if($record['id']==$unit && $record['academic']==$year){
                      return $record['total'];
                  }
              }
              return FALSE;
          } catch (Exception $ex) {
              return FALSE;
          }
      }
      public static function classesPerUnitPerYear($academic,$unit){
          try{
              $records = self::countAllClasses();
              if(!$records){
                  return FALSE;
              }
              $res = [];
              foreach ($records as $record){
                  if($record['id']==$unit && $record['academic']==$academic){
                      array_push($res, $record);
                  }
              }
              return $res;
          } catch (Exception $ex) {
              return FALSE;
          }
      }
      public static function getYears(){
          try{
              $sql = "SELECT DISTINCT(year) FROM schedules ORDER BY year desc";
              if(self::getError()){
                  return FALSE;
              }
              $qr = self::connect()->prepare($sql);
              if(!$qr){
                  return FALSE;
              }
              $qr->execute();
              $res = $qr->fetchAll(PDO::FETCH_ASSOC);
              return $res;
          } catch (Exception $ex) {
              return FALSE;
          }
      }
      public static function countTheAttendance(){
          try{
              $sql = "select students.names,students.regno,attendance.student,schedules.unit,schedules.year,attendance.year_attended,count(attendance.student) as total from students,schedules,attendance inner join classes on classes.id = attendance.class where classes.schedule = schedules.id and students.id=attendance.student and attendance.confirmed=1 group by schedules.unit,classes.schedule,attendance.year_attended,attendance.student;";
              if(self::getError()){
                  return FALSE;
              }
              $qr = self::connect()->prepare($sql);
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
      /***************************************************************
       * Get a list of students doing a unit
       */
      public static function getAllStudentsTakingUnits($unit){
          try{
              $sql = "select distinct(students.id),students.names,students.regno from students inner join units on units.course=students.course and units.year=students.year and units.semester=students.sem and units.id=?";
              if(self::getError()){
                  return FALSE;
              }
              $qr = self::connect()->prepare($sql);
              $qr->bindParam(1,$unit);
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
      public static function getUnitAndYear($unit,$year){
          try{
              $records = self::countTheAttendance();
              if(!$records){
                  return FALSE;
              }
              $res = [];
              foreach ($records as $record){
                  if($record['year']==$year && $record['unit']==$unit){
                      array_push($res, $record);
                  }
              }
              return $res;
          } catch (Exception $ex) {
              return FALSE;
          }
      }
      public static function hasScores($id){
          try{
              $records = self::countTheAttendance();
              if(!$records){
                  return FALSE;
              }
              foreach ($records as $record){
                  if($record['student']==$id){
                      return $record;
                  }
              }
              return FALSE;
          } catch (Exception $ex) {
              return FALSE;
          }
      }
      public static function getUnitForYear($unit,$year){
          try{
              $records = self::glueUp($unit,$year);
              if(!$records){
                  return FALSE;
              }
              $res = [];
              foreach ($records as $record){
                  if($record['year']==$year){
                      array_push($res, $record);
                  }
              }
              return $res;
          } catch (Exception $ex) {
              return FALSE;
          }
      }
      public static function glueUp($unit,$year){
          try{
              $records = self::getAllStudentsTakingUnits($unit);
              if(!$records){
                  return FALSE;
              }
              $res = [];
              foreach ($records as $record){
                  if(self::hasScores($record['id'])){
                      $record['totalclassess'] = self::countByUnit($unit,$year);
                      array_push($res, self::hasScores($record['id']));
                  }else{
                      $record['total'] = 0;
                      $record['year'] = $year;
                      $record['totalclassess'] = self::countByUnit($unit,$year)!=false?self::countByUnit($unit,$year):0;
                      array_push($res, $record);
                  }
              }
              return $res;
          } catch (Exception $ex) {
              return FALSE;
          }
      }
      public static function getToRecommend($lecturer,$unit,$evaluation){
        try{
            $records = self::getLecturerRatingByUnit($lecturer, $unit);
            $res = [];
            if(!$records){
                return FALSE;
            }
            foreach ($records as $record){
                if($record['evaluation']==$evaluation){
                    array_push($res, $record);
                }
            }
            return $res;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    public static function recommendations($lec){
        try{
            $sql = "SELECT * FROM recommendations WHERE lecturer=?";
            if(self::getError()){
                return FALSE;
            }
            $qr = self::connect()->prepare($sql);
            $qr->bindParam(1,$lec);
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
    public static function getRecommendByID($id){
        try{
            $sql = "SELECT * FROM recommendations WHERE id=?";
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
            return $records;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
  }
 ?>
