<?php

require_once('conn.php');
$GLOBALS['connection'] = $connection;

class Teacher{
    private $name;
    private $db;

    function __construct(){
        $this->db = $GLOBALS['connection'];
    }

    function deleteQuiz($quizid){
        $stmt1 = $this->db->prepare("DELETE FROM questions WHERE quiz_id = ?");
    $stmt1->bind_param("i", $quizid);
    $stmt1->execute();

    $stmt2 = $this->db->prepare("DELETE FROM quiz WHERE quiz_id = ?");
    $stmt2->bind_param("i", $quizid);
    return $stmt2->execute();
    }

    function selectQuizStudents($quiz_id, $userid){
        $stmt = $this->db->prepare("INSERT INTO quiz_students (quiz_id, student_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $quiz_id, $userid);
        $stmt->execute();
    }
    


}

?>
