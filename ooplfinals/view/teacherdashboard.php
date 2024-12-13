<?php
include ('../classes/conn.php');
include('../classes/quiz.php');
include('../classes/teacher.php');
include('../partials/header.php');

$userId = $_GET['id'];

if(isset($_POST['createquiz'])){
    $res = $connection->query("INSERT INTO `quiz` (`user_id`) VALUES ('$userId')");

    if($res){
        $quizId = $connection->insert_id;
        header("Location: /ooplfinals/view/createquiz.php?id=$userId&quizid=$quizId");
        exit;
    } else {
        echo "Error: " . $connection->error;
    }
}

if (isset($_POST['delete_quiz'])){
    $delete_qid = $_POST['quiz_id'];
    $d = new Teacher();
    $del = $d->deleteQuiz($delete_qid);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard - Quiz List</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #0047ab;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }


        button:disabled {
            background-color: #ccc;
        }


        form {
            display: inline;
        }

        .action-btns {
            display: flex;
            justify-content:space-around;
            gap: 10px;
            font-size: 12px;
        }

        /* .action-btns button {
            margin: 5px;
            
        } */

        .create-quiz-btn {
            background-color:#007bff;
            color: white;
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            border: none;
            display: flex;
            justify-self: end;
        }

        .create-quiz-btn:hover {
            background-color: #218838;
        }

        .delete{
            color: red;
            background-color: #f4f7fa;
            border: 2px solid red;
            border-radius: 5px;
            padding: 10px;
        }

        .delete:hover{
            background-color: red;
            color: white;
        }

        .editquiz{
            color: yellowgreen;
            background-color: #f4f7fa;
            border: 2px solid yellowgreen;
            text-decoration: none;
            padding-left: 20px;
            padding-right: 20px;

        }

        .editquiz:hover{
            background-color: yellowgreen;
            color: white;
            
        }

        .viewstudents{
            color: blue;
            background-color: #f4f7fa;
            border: 2px solid blue;
            text-decoration: none;
            padding-left: 10px;
            padding-right: 10px;
        }

        .viewstudents:hover{
            background-color: blue;
            color: white;
            
        }

        .editquiz, .viewstudents{
            display: flex;
            align-items: center;
            border-radius: 10px;
        }




    </style>
</head>
<body>

<div class="container">
    <form method="post">
        <button type="submit" name="createquiz" class="create-quiz-btn"> + Create Quiz</button>
    </form>

    <h2>Quiz List</h2>

    <table>
        <thead>
            <tr>
                <th>Quiz Title</th>
                <th>Subject</th>
                <th>Total Points</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $teachq = new Quiz();
                $tq = $teachq->quizList($userId);
                $tot = $teachq->getTotalPoints($userId);

                foreach($tq as $key => $value) {
                    echo '
                    <tr>
                        <td>' . htmlspecialchars($value['quiz_title']) . '</td>
                        <td>' . htmlspecialchars($value['subject']) . '</td>
                        <td>' . htmlspecialchars($value['total_points']) . '</td>
                        <td class="action-btns">
                            <a href="/ooplfinals/view/quizstatus.php?id=' . $userId . '&quizid=' . $value['quiz_id'] . '" class="viewstudents">View Students</a>
                            <a href="/ooplfinals/view/editquiz.php?id='. $userId. '&quizid='. $value['quiz_id']. '" class="editquiz">Edit</a>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="quiz_id" value="' . $value['quiz_id'] . '">
                                <button type="submit" name="delete_quiz" class="delete">Delete</button>
                            </form>
                        </td>
                    </tr>';
                }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
