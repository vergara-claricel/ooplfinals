<?php

require_once('conn.php');
$GLOBALS['connection'] = $connection;

class Quiz{
    private $db;

    function __construct()
    {
        $this->db = $GLOBALS['connection'];
    }

    function addQuiz($quiztitle, $subject, $userId, $quizId){
        $add = $this->db->query("UPDATE `quiz` SET`quiz_title`='$quiztitle',`subject`='$subject' WHERE `user_id` = $userId and `quiz_id` = $quizId");
    return $add;
    }

    function quizList($userid){
        $stmt = $this->db->prepare("SELECT q.quiz_id, q.quiz_title, q.subject, IFNULL(SUM(questions.qpoints), 0) AS total_points
                                FROM quiz q
                                LEFT JOIN questions ON q.quiz_id = questions.quiz_id
                                WHERE q.user_id = ?
                                GROUP BY q.quiz_id");
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    function getTotalPoints($userid){
        // with teacher userid
            $stmt = $this->db->prepare("SELECT q.quiz_id, q.quiz_title, q.subject, IFNULL(SUM(questions.qpoints), 0) AS total_points
                FROM quiz q
                LEFT JOIN questions ON q.quiz_id = questions.quiz_id
                WHERE q.user_id = ?
                GROUP BY q.quiz_id");
            $stmt->bind_param("i", $userid);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

    
        
}

$quizobj = new Quiz();



?>


