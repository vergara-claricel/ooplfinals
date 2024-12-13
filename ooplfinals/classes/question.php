<?php

require_once('conn.php');
$GLOBALS['connection'] = $connection;

class Question{
    private $db;
    // private $totalpoints;

    function __construct()
    {
        $this->db = $GLOBALS['connection'];

    }

    function addQuestion($quiz_id, $ques, $option1, $option2,$option3,$option4, $correct, $qpoints){
        $stmt = $this->db->prepare("INSERT INTO `questions` (`quiz_id`, `question`, `option1`, `option2`, `option3`, `option4`, `correctans`, `qpoints`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssssi", $quiz_id, $ques, $option1, $option2, $option3, $option4, $correct, $qpoints);

       if($stmt->execute()){
        return true;
       } else{
        return false;
       }
    }

    function displayquestions($quizid){
        $dis = $this->db->query("SELECT * from `questions` where `quiz_id` = '$quizid'")->fetch_all(MYSQLI_ASSOC);
        return $dis;
    }

    public function getQuestionById($question_id) {
        $stmt = $this->db->prepare("SELECT * FROM questions WHERE question_id = ?");
        $stmt->bind_param("i", $question_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();  
    }
    

    function deleteQuestion($question_id){
        $stmt = $this->db->prepare("DELETE FROM questions WHERE question_id = ?");
        $stmt->bind_param("i", $question_id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function displayEditQuestion ($question_id){
        $stmt = $this->db->prepare("SELECT * FROM questions WHERE question_id = ?");
        $stmt->bind_param("i", $question_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $question_data = $result->fetch_assoc();
        return $question_data;
    }

    function updateQuestion($question_text, $option1, $option2, $option3, $option4, $correct, $points, $question_id){
        $stmt = $this->db->prepare("UPDATE questions SET question = ?, option1 = ?, option2 = ?, option3 = ?, option4 = ?, correctans = ?, qpoints = ? WHERE question_id = ?");
        $stmt->bind_param("ssssssii", $question_text, $option1, $option2, $option3, $option4, $correct, $points, $question_id);
        return $stmt;
    }
    

}

$qobj = new Question();
?>