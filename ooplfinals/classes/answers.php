<?php

require_once('../classes/conn.php');
$GLOBALS['connection'] = $connection;

class Answers{
    private $db;

    function __construct()
    {
        $this->db = $GLOBALS['connection'];

    }

    function getCorrectAns($quiz_id, $student_id, $score){
        $query = "INSERT INTO quiz_results (quiz_id, student_id, score) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iii", $quiz_id, $student_id, $score);
        $stmt->execute();
    }

}

$ansobj= new Answers();

?>