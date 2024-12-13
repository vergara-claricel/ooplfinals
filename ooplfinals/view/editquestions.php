<?php
include('../classes/question.php');
include('../classes/conn.php');
include('../classes/student.php');
include('../partials/header.php');



$question_id = $_GET['quesid'];
// Fetch the existing question data
$question = $qobj->getQuestionById($question_id);
// var_dump($question);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_question'])) {
        $question_text = $_POST['question_text'];
        $options = $_POST['option'];
        $correct_answer_index = $_POST['is_right'];
        $points = $_POST['qpoints'];

        // Get the correct answer based on index
        $correct_answer = $options[$correct_answer_index];

        // Check if all fields are set and valid
        if (!empty($question_text) && !empty($options) && isset($correct_answer_index) && !empty($points)) {
            // Process the update
            $upd = $qobj->updateQuestion($question_text, $options[0], $options[1], $options[2], $options[3], $correct_answer, $points, $question_id);
            if($upd->execute()){
                header("Location:/ooplfinals/view/editquestions.php?id=$userId&quizid=$quizId&quesid=$question_id");
                echo "Question updated successfully.";
                var_dump($_POST);
        } else {
            echo "Please fill in all the fields.";
        }
    }
        
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Questions</title>
    <link rel="stylesheet" href="../css/editquestions.css">
</head>
<body>

    <div class="container">
        <h2>Edit Question for Quiz</h2>
        <div class="navigation">
            <a href="/ooplfinals/view/teacherdashboard.php?id=<?php echo $userId; ?>" class="nav-link">Back to Dashboard</a>
            <a href="/ooplfinals/view/addquestions.php?id=<?php echo $userId; ?>&quizid=<?php echo $quizId; ?>" class="nav-link">Add Question</a>
        </div>

        <h3>Edit Question</h3>

        <form method="post" class="question-form">
            <input type="hidden" name="question_id" value="<?php echo $question['question_id']; ?>">

            <div class="form-group">
                <label for="question_text">Question Text:</label>
                <input type="text" name="question_text" value="<?php echo $question['question']; ?>" required>
            </div>

            <div class="form-group">
                <label for="option[0]">Option 1:</label>
                <input type="text" name="option[0]" value="<?php echo $question['option1']; ?>" required>
            </div>

            <div class="form-group">
                <label for="option[1]">Option 2:</label>
                <input type="text" name="option[1]" value="<?php echo $question['option2']; ?>" required>
            </div>

            <div class="form-group">
                <label for="option[2]">Option 3:</label>
                <input type="text" name="option[2]" value="<?php echo $question['option3']; ?>" required>
            </div>

            <div class="form-group">
                <label for="option[3]">Option 4:</label>
                <input type="text" name="option[3]" value="<?php echo $question['option4']; ?>" required>
            </div>

            <div class="form-group">
                <label for="qpoints">Points:</label>
                <input type="number" name="qpoints" value="<?php echo $question['qpoints']; ?>" required>
            </div>

            <div class="form-group">
                <label for="is_right">Correct Answer:</label>
                <select name="is_right" required>
                    <option value="0" <?php echo ($question['correctans'] == $question['option1']) ? 'selected' : ''; ?>>Option 1</option>
                    <option value="1" <?php echo ($question['correctans'] == $question['option2']) ? 'selected' : ''; ?>>Option 2</option>
                    <option value="2" <?php echo ($question['correctans'] == $question['option3']) ? 'selected' : ''; ?>>Option 3</option>
                    <option value="3" <?php echo ($question['correctans'] == $question['option4']) ? 'selected' : ''; ?>>Option 4</option>
                </select>
            </div>

            <div class="form-buttons">
                <!-- Both buttons are now inside the same form -->
                <button type="submit" name="update_question" class="button update-btn">Update Question</button>
            </div>
        </form>
    </div>

</body>
</html>
