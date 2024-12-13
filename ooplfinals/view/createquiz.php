<?php
include('../classes/quiz.php');
include('../classes/question.php');
include('../partials/header.php');

if (isset($_POST['newquiz'])) {
    $quiztitle = $_POST['quiztitle'];
    $subject = $_POST['subject'];
    $quizid = $_GET['quizid'];
    $userId = $_GET['id'];

    $quiz = new Quiz();
    $newquiz = $quiz->addQuiz($quiztitle, $subject, $userId, $quizid);

    if($newquiz){
        header("Location: /ooplfinals/view/addquestions.php?id=$userId&quizid=$quizid");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Quiz</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 60%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            color: #333;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Create New Quiz</h2>

    <form method="post">
        <div class="form-group">
            <label for="quiztitle">Quiz Title</label>
            <input type="text" name="quiztitle" id="quiztitle" required>
        </div>

        <div class="form-group">
            <label for="subject">Subject</label>
            <input type="text" name="subject" id="subject" required>
        </div>

        <button type="submit" name="newquiz">Save Quiz</button>
    </form>
</div>

</body>
</html>
