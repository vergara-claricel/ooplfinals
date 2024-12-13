<?php
include('../classes/conn.php');
include('../partials/header.php');
include('../classes/quizresults.php');
include('../classes/answers.php');

$quiz_id = $_GET['quizid'];
$student_id = $_GET['id'];
$quiztitle = $_GET['quiztitle'];

// Fetch quiz questions
$query = "SELECT * FROM questions WHERE quiz_id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$result = $stmt->get_result();

echo "<form method='post' class='quiz-form'>"; // Form for submitting answers
echo "<h2 class='quiz-title'>Quiz: " . $quiztitle . "</h2>";

while ($question = $result->fetch_assoc()) {
    echo "<div class='question-box'>";
    echo "<p class='question-text'>" . $question['question'] . "</p>";

    for ($i = 1; $i <= 4; $i++) {
        echo "<div class='option'>";
        echo "<label>";
        echo "<input type='radio' name='question_" . $question['question_id'] . "' value='" . $question['option'.$i] . "'>";
        echo $question['option'.$i];
        echo "</label>";
        echo "</div>";
    }

    echo "</div>";
}

echo "<button type='submit' name='submit_quiz' class='submit-button'>Submit</button>";
echo "</form>";

if (isset($_POST['submit_quiz'])) {
    $score = 0;

    // Fetch the correct answers from the database for scoring
    $query_answers = "SELECT question_id, correctans, qpoints FROM questions WHERE quiz_id = ?";
    $stmt_answers = $connection->prepare($query_answers);
    $stmt_answers->bind_param("i", $quiz_id);
    $stmt_answers->execute();
    $answers_result = $stmt_answers->get_result();

    // Loop through each question's correct answer and calculate the score
    while ($answer = $answers_result->fetch_assoc()) {
        $correct_answer = $answer['correctans'];
        $question_id = $answer['question_id'];

        // Check the student's answer
        if (isset($_POST['question_' . $question_id]) && $_POST['question_' . $question_id] == $correct_answer) {
            $score += $answer['qpoints'];
        }
    }

    // Save the score in the quiz_results table
    $qrobj->saveResults($quiz_id, $student_id, $score);

    header("Location: /ooplfinals/view/studentdashboard.php?id=$student_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take the Quiz</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .quiz-form {
            max-width: 800px;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .quiz-title {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .question-box {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #fafafa;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .question-text {
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
        }

        .option {
            margin-left: 20px;
            margin-bottom: 10px;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        .submit-button {
            width: 100%;
            padding: 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }

        .submit-button:hover {
            background-color: #45a049;
        }

        @media (max-width: 600px) {
            .quiz-form {
                padding: 20px;
                width: 90%;
            }

            .submit-button {
                font-size: 16px;
                padding: 12px;
            }
        }
    </style>
</head>
<body>

</body>
</html>
