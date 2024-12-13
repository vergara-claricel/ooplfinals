<?php
include('../classes/question.php');
include('../classes/student.php');
include('../partials/header.php');


if (isset($_POST['saveques'])) {
    $question = $_POST['question'];
    $options = $_POST['option'];

    // Make sure is_right is set and is a valid index
    if (isset($_POST['is_right']) && in_array($_POST['is_right'], [0, 1, 2, 3])) {
        $is_right = intval($_POST['is_right']); // Ensure is_right is treated as an integer
        $qpoints = $_POST['qpoints'];
        $quizid = $_GET['quizid'];
        $userId = $_GET['id'];

        // Ensure the correct option index is valid
        if (isset($options[$is_right])) {
            $correct = $options[$is_right]; // Get the correct answer based on the selected index
            $qobj->addQuestion($quizid, $question, $options[0], $options[1], $options[2], $options[3], $correct, $qpoints);
            var_dump($correct);
        } else {
            echo "Invalid correct answer index.";
        }
    } else {
        echo "Please select a valid correct answer.";
    }


}



if(isset($_POST['savequiz'])){
    $userId = $_GET['id'];
    header("Location: /ooplfinals/view/teacherdashboard.php?id=$userId");
    exit;
}

if(isset($_POST['addstudents'])){
    $quizid = $_GET['quizid'];
    $userId = $_GET['id'];
    header("Location:/ooplfinals/view/addstudents.php?id=$userId&quizid=$quizid");
}

if (isset($_POST['delete_student'])) {
    $student_id = $_POST['student_id'];
    $quiz_id = $_POST['quiz_id'];
    $d = new Student();
    $del = $d->deleteStudent($quiz_id, $student_id);
    if($del){
        header("Location: /ooplfinals/view/addquestions.php?id={$_GET['id']}&quizid=$quiz_id");
        exit;
    }
}

if (isset($_POST['delete_question'])) {
    $question_id = $_POST['question_id'];
    $dq = new Question();
    $delq = $dq->deleteQuestion($question_id);
    if($delq){
        header("Location: /ooplfinals/view/addquestions.php?id={$_GET['id']}&quizid={$_GET['quizid']}");
        exit;
    }
}

if(isset($_POST['edit_question'])){
    $question_id = $_POST['question_id'];
    header("Location: /ooplfinals/view/editquestions.php?id={$_GET['id']}&quizid={$_GET['quizid']}&quesid=$question_id");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Quiz Questions and Students</title>
 <link rel="stylesheet" href="../css/addquestions.css">
</head>
<body>

<div class="container">
    <h2>Manage Quiz Questions and Students</h2>
    <div class="addbtns">
    <form method="post">
        <button id="addquestion">+ Add Question</button>
            <button type="submit" name="addstudents" id="addstudents"> + Add Students</button>
        </form>
    </div>
    

    <form method="post">
        <div class="questionsform" id="qform">
            <div class="form-group">
                <label for="question">Question</label>
                <textarea type="text" name="question" id="question" required></textarea>
            </div>

            <div class="form-group">
                <label for="option[0]">Option 1</label>
                <textarea name="option[0]" required></textarea>
                <input type="radio" name="is_right" value="0"> Correct Answer
            </div>

            <div class="form-group">
                <label for="option[1]">Option 2</label>
                <textarea name="option[1]" required></textarea>
                <input type="radio" name="is_right" value="1"> Correct Answer
            </div>

            <div class="form-group">
                <label for="option[2]">Option 3</label>
                <textarea name="option[2]" required></textarea>
                <input type="radio" name="is_right" value="2"> Correct Answer
            </div>

            <div class="form-group">
                <label for="option[3]">Option 4</label>
                <textarea name="option[3]" required></textarea>
                <input type="radio" name="is_right" value="3"> Correct Answer
            </div>

            <div class="form-group">
                <label for="qpoints">Points</label>
                <input type="number" name="qpoints" required>
            </div>

            <button type="submit" id="saveques" name="saveques">Save Question</button>
        </div>
    </form>

    <div class="listcontainer">
    <div class="questionslist">
        <h3>Existing Questions</h3>
        <?php
        $quizid = $_GET['quizid'];
        $queztions = $qobj->displayquestions($quizid);
        foreach($queztions as $value){
            echo '
                <div class="question-box">
                    <div class="question-content">
                        <p class="question-text">' . $value['question'] . '</p>
                    </div>
                    
                    <div class="question-actions">
                        <form method="post" class="action-form">
                            <input type="hidden" name="question_id" value="' . $value['question_id'] . '">
                            <button type="submit" name="delete_question" class="delete-button">Delete</button>
                        </form>
                        <form method="post" class="action-form">
                            <input type="hidden" name="question_id" value="' . $value['question_id'] . '">
                            <button type="submit" name="edit_question" class="edit-button">Edit</button>
                        </form>
                    </div>
            </div>';
        }
        ?>
    </div>

    <div class="studentslist">
        <h3>Enrolled Students</h3>
        <?php
        $quiz_id = $_GET['quizid'];
        $stmt = $connection->prepare("SELECT s.name, s.section, s.user_id
                                      FROM students s
                                      INNER JOIN quiz_students qs ON s.user_id = qs.student_id
                                      WHERE qs.quiz_id = ?");
        $stmt->bind_param("i", $quiz_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while($row = $result->fetch_assoc()) {
            echo '<p>' . $row['name'] . ' - ' . $row['section'] . '</p>
            <form method="post">
                <input type="hidden" name="student_id" value="' . $row['user_id'] . '">
                <input type="hidden" name="quiz_id" value="' . $quiz_id . '">
                <button type="submit" name="delete_student">Delete Student</button>
            </form>';
        }
        ?>
    </div>
    </div>

    <form method="post" class="savequizbtn">
        <button type="submit" name="savequiz" class="savequiz">SAVE QUIZ</button>
    </form>
</div>

<script>
    document.getElementById('addquestion').addEventListener('click', function(event){
        event.preventDefault();
        document.getElementById('qform').style.display = 'block';
    });

    document.getElementById('saveques').addEventListener('click', function(){
        document.getElementById('qform').style.display = 'none';
    });
</script>

</body>
</html>
