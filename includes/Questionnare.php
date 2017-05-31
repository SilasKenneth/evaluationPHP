<?php
  abstract class Questionnare extends DB{
    public static function getQuestions($json=false){
        try{
            if(self::getError()) return false;
            $cn = self::connect();
            $sql = "SELECT questions.id,questions.qtype,questions.survey,questions.topic,questions.bodytext FROM questions INNER JOIN surveys ON questions.survey=surveys.id GROUP BY questions.survey,questions.id";
            $qr = $cn->prepare($sql);
            if(!$qr) return false;
            $qr->execute();
            $records = $qr->fetchAll(PDO::FETCH_ASSOC);
            if(!count($records))return false;
            return $records;
        }catch (Exception $x){
            //print_r($x->getMessage());
            return false;
        }
    }
    public static function checkIfEvaluationExists($id){
        try{
            $sql = "SELECT * FROM surveys WHERE id=?";
            if(self::getError()) return false;
            $cn = self::connect();
            $qr = $cn->prepare($sql);
            $qr->bindParam(1,$id);
            if(!$qr) return false;
            $qr->execute();
            $records = $qr->fetchAll(PDO::FETCH_ASSOC);
            if(count($records)==0) return false;
            return [true,$records];
        }catch (Exception $ex){
//            echo $ex->getMessage();
            return false;
        }
    }
    public static function addQuestion($qtype,$survey,$bodytext){
        try{
            $co = self::connect();
            if (self::getError()) {
                return false;
            }
            $sql ="INSERT INTO questions(qtype,survey,bodytext,topic)VALUES(?,?,?,?); ";
            $topic = 1;
            $qr = $co->prepare($sql);
            $qr->bindParam(1,$qtype);
            $qr->bindParam(2,$survey);
            $qr->bindParam(4,$topic);
            $qr->bindParam(3,$bodytext);
            if (!$qr) {
                return false;
            }
            $qr->execute();
            return true;
        }catch (Exception $ex){
            return false;
        }
    }
    public static function getQuizById($id){

    }
    public static function deleteQuestion($id){
        try{
            $co = self::connect();
            if(self::getError()) return false;
            if(!self::quizExists($id)) return false;
            $sql = "DELETE FROM questions WHERE id=?";
            $qr = $co->prepare($sql);
            $qr->bindParam(1,$id);
            if(!$qr) return false;
            $qr->execute();
            return true;
        }catch (Exception $ex){
            //echo $ex->getMessage();
            return false;
        }
    }

      private static function quizExists($id){
        try{
            if(!self::getQuestions()) return false;
            $quizes = self::getQuestions();
            if(!count($quizes)){
                return false;
            }
            foreach ($quizes as $quize){
                if($quize['id']==$id){
                    return $quize;
                }
            }
            return false;
        }catch (Exception $ex){
            return false;
        }
      }
      public static function getQuizeByEvaluation($survey){
          try{
              $res = [];
              $surve = self::getQuestions();
              if(!$surve) return false;
              if(count($surve)==0){
                  return false;
              }
              foreach ($surve as $item){
                  if($item['Evaluation']==$survey){
                      array_push($res,$item);
                  }
              }
              return $res;
          }catch (PDOException $ex){
              return false;

          }
      }
      public static function getQuestionByType($id){
          try{
              if(self::getError())return false;
              $cn = self::connect();
              $sql = "SELECT questions.survey,questions.qtype, questions.bodytext FROM questions INNER join surveys ON surveys.id = questions.survey WHERE surveys.status=1 AND questions.qtype=? ";
              $qr = $cn->prepare($sql);
              $qr->bindParam(1,$id);
              if(!$qr) return false;
              $qr->execute();
              $records = $qr->fetchAll(PDO::FETCH_ASSOC);
              if(!$records) return false;
              return $records;
          }catch (Exception $x){
              return false;
          }
      }
  }
//  $ans = Questionnare::deleteQuestion(3);
//  $ans1 = Questionnare::getQuizeByEvaluation(1);
//  $rec = Questionnare::checkIfSurveyExist(4);
//  print_r($rec);
//  echo "<br>";
//  if(!$ans1){
//      echo "Maybe questions don't exist for that survey";
//  }else{
//
//      echo "<b>".count($ans1)."</b> ".(count($ans1)>1?"questions":" question ")." exist in the survey. Want to add more?";
//  }
//  if(!$ans){
//      echo "<h1 color='red'>Could not delete record</h1>";
//  }else{
//      echo "Success";
//  }
 ?>
