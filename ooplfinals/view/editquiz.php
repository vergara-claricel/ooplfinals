<?php
include('../classes/conn.php');
include('../classes/question.php');

$userId = $_GET['id'];
$quizId = $_GET['quizid'];

// Fetch quiz questions
$questions = $qobj->displayquestions($quizId);

if (isset($_POST['update_question'])) {
    $question_id = $_POST['question_id'];
    $question_text = $_POST['question_text'];
    $options = $_POST['option'];
    $correct_answer_index = $_POST['is_right'];  
    $points = $_POST['qpoints'];

    $correct_answer = $options[$correct_answer_index];

    // Update the question in the database
    if ($correct_answer !== null) {
        $stmt = $connection->prepare("UPDATE questions SET question = ?, option1 = ?, option2 = ?, option3 = ?, option4 = ?, `correctans` = ?, qpoints = ? WHERE question_id = ? AND quiz_id = ?");
        $stmt->bind_param("ssssssiii", $question_text, $options[0], $options[1], $options[2], $options[3], $correct_answer, $points, $question_id, $quizId);
        if ($stmt->execute()) {
            header("Location:/ooplfinals/view/editquiz.php?id=$userId&quizid=$quizId&quesid=$question_id");
        } else {
            echo "Error: " . $connection->error;
        }
    } else {
        echo "Please select a correct answer.";
    }
}

if (isset($_POST['delete_question'])) {
    $question_id = $_POST['question_id'];

    $stmt = $connection->prepare("DELETE FROM questions WHERE question_id = ? AND quiz_id = ?");
    $stmt->bind_param("ii", $question_id, $quizId);
    if ($stmt->execute()) {
        echo "Question deleted successfully!";
        header("Location:/ooplfinals/view/editquiz.php?id=$userId&quizid=$quizId&quesid=$question_id");

    } else {
        echo "Error: " . $connection->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Questions</title>

    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 30px auto;
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2, h3 {
            text-align: center;
            color: #333;
        }

        .navigation {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .nav-link {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }

        .nav-link:hover {
            text-decoration: underline;
        }

        /* Form Section */
        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }

        input[type="text"], input[type="number"], select, textarea {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            width: 100%;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus, input[type="number"]:focus, select:focus, textarea:focus {
            border-color: #007bff;
            outline: none;
        }

        select {
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .form-buttons {
            display: flex;
            justify-content: space-between;
        }

        button {
            padding: 12px 25px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 48%;
        }

        .update-btn {
            background-color: #4CAF50;
            color: white;
        }

        .update-btn:hover {
            background-color: #45a049;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 15px;
            }

            .form-group label {
                font-size: 12px;
            }

            button {
                font-size: 14px;
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Edit Questions for Quiz</h2>
        <div class="navigation">
            <a href="/ooplfinals/view/teacherdashboard.php?id=<?php echo $userId; ?>" class="nav-link">Back to Dashboard</a>
            <a href="/ooplfinals/view/addquestions.php?id=<?php echo $userId; ?>&quizid=<?php echo $quizId; ?>" class="nav-link">Add Question</a>
        </div>

        <h3>Questions List</h3>

        <?php foreach ($questions as $question): ?>
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
                    <select name="is_right">
                        <option value="0" <?php echo ($question['correctans'] == $question['option1']) ? 'selected' : ''; ?>>Option 1</option>
                        <option value="1" <?php echo ($question['correctans'] == $question['option2']) ? 'selected' : ''; ?>>Option 2</option>
                        <option value="2" <?php echo ($question['correctans'] == $question['option3']) ? 'selected' : ''; ?>>Option 3</option>
                        <option value="3" <?php echo ($question['correctans'] == $question['option4']) ? 'selected' : ''; ?>>Option 4</option>
                    </select>
                </div>

                <div class="form-buttons">
                    <button type="submit" name="update_question" class="update-btn">Update Question</button>
                    <button type="submit" name="delete_question" class="delete-btn">Delete Question</button>
                </div>
            </form>
            <hr>
        <?php endforeach; ?>
    </div>

</body>
</html>
