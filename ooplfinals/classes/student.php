<?php

require_once('conn.php');
$GLOBALS['connection'] = $connection;

class Student{
    private $section;
    private $studentId;
    private $db;

    function __construct(){
        $this->db = $GLOBALS['connection'];
    }
    
    function getStudents(){
        $students = $this->db->query("SELECT * from `students`")->fetch_all(MYSQLI_ASSOC);
        return $students;
    }

    function deleteStudent($quiz_id, $student_id){
        $stmt = $this->db->prepare("DELETE FROM quiz_students WHERE quiz_id = ? AND student_id = ?");
        $stmt->bind_param("ii", $quiz_id, $student_id);
        if ($stmt->execute()) {
            echo "Student removed successfully.";
        } else {
            echo "Error: " . $this->db->error;
        }
    }

    public function getStudentsGroupedBySection() {
        // Query to fetch students grouped by section
        $stmt = $this->db->prepare("SELECT * FROM students ORDER BY section, name");
        $stmt->execute();
        $result = $stmt->get_result();
        $students_by_section = [];
        while ($row = $result->fetch_assoc()) {
            $students_by_section[$row['section']][] = $row;
        }
        return $students_by_section;
    }
    
    function getAssignedQuizzes($student_id){
        $query = "
            SELECT q.quiz_id, q.quiz_title, q.subject
            FROM quiz q
            JOIN quiz_students qs ON q.quiz_id = qs.quiz_id
            WHERE qs.student_id = ?
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $student_id);  
        $stmt->execute();
        $result = $stmt->get_result();
        $assigned_quizzes = $result->fetch_all(MYSQLI_ASSOC);
        return $assigned_quizzes;
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

}

$sobj = new Student();

?>