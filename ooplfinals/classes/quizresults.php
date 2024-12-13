<?php

include('../classes/conn.php');

class QuizResults{

    private $db;

    function __construct()
    {
        $this->db = $GLOBALS['connection'];
    }

    function saveResults($quiz_id, $student_id, $score){
        $query = "INSERT INTO quiz_results (quiz_id, student_id, score) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iii", $quiz_id, $student_id, $score);
        $stmt->execute();

    }

    function getQuizResults($student_id){
        $query = "SELECT quiz_id, score FROM quiz_results WHERE student_id = ?";
        $stmt2 = $this->db->prepare($query);
        $stmt2->bind_param("i", $student_id);
        $stmt2->execute();
        $score_result = $stmt2->get_result();
        $scores = $score_result->fetch_all(MYSQLI_ASSOC);
        return $scores;
    }

    function getAttemptTime($quizId){
        $stmt = $this->db->prepare("
            SELECT s.user_id, s.name, s.section, 
                qa.score, qa.attempt_at
            FROM students s
            LEFT JOIN quiz_results qa ON s.user_id = qa.student_id AND qa.quiz_id = ?
            WHERE s.user_id IN (SELECT student_id FROM quiz_students WHERE quiz_id = ?)
            GROUP BY s.user_id
        ");
        $stmt->bind_param("ii", $quizId, $quizId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    
}

$qrobj = new QuizResults();

?>