<?php
include('../classes/conn.php');
include('../partials/header.php');
include('../classes/student.php');
include('../classes/quizresults.php');
$student_id = $_GET['id']; 

// Fetch assigned quizzes
$assigned_quizzes = $sobj->getAssignedQuizzes($student_id);

// Fetch quiz results (score)
$scores = $qrobj->getQuizResults($student_id);

$quiz_scores = [];
foreach ($scores as $score_row) {
    $quiz_scores[$score_row['quiz_id']] = $score_row['score'];
}

if (isset($_POST['submit_quiz'])) {
    $quiz_id = $_GET['quizid'];
    $student_id = $_GET['id'];
    $score = 0;

    // Fetch the questions for quiz
    $query = "SELECT question_id, correctans, qpoints FROM questions WHERE quiz_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $quiz_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($question = $result->fetch_assoc()) {
        $correct_answer = $question['correctans'];
        $student_answer = $_POST['question_' . $question['question_id']];

        if ($student_answer == $correct_answer) {
            $score += $question['qpoints']; 
        }
    }

    $qr = $qrobj->saveResults($quiz_id, $student_id, $score);
    header("Location: /ooplfinals/view/studentdashboard.php?id=$student_id");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigned Quizzes</title>
    <link rel="stylesheet" href="../css/studentdb.css">
</head>
<body>

<div class="container">
    <?php if ($assigned_quizzes): ?>
        <h2>Assigned Quizzes</h2>
        <table>
            <thead>
                <tr>
                    <th>Quiz Title</th>
                    <th>Subject</th>
                    <th>Score</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($assigned_quizzes as $quiz): 
                    // Fetch the total points for the quiz
                    $total_points_query = "SELECT SUM(qpoints) AS total_points FROM questions WHERE quiz_id = ?";
                    $stmt3 = $connection->prepare($total_points_query);
                    $stmt3->bind_param("i", $quiz['quiz_id']);
                    $stmt3->execute();
                    $result3 = $stmt3->get_result();
                    $total_points = $result3->fetch_assoc()['total_points'];
                ?>
                    <tr>
                        <td><?= htmlspecialchars($quiz['quiz_title']) ?></td>
                        <td><?= htmlspecialchars($quiz['subject']) ?></td>
                        <td>
                            <?php 
                                if (isset($quiz_scores[$quiz['quiz_id']])) {
                                    $score = $quiz_scores[$quiz['quiz_id']];
                                    echo "<span class='quiz-score'>$score / $total_points</span>";
                                } else {
                                    echo "<span class='score-text'>Not Taken</span>";
                                }
                            ?>
                        </td>

                        <td>
                            <?php if (!isset($quiz_scores[$quiz['quiz_id']])): ?>
                                <a href="takequiz.php?id=<?= $student_id ?>&quizid=<?= $quiz['quiz_id'] ?>&quiztitle=<?= urlencode($quiz['quiz_title']) ?>" class="action-btn">Take Quiz</a>
                            <?php else: ?>
                                <button class="completed-btn" disabled>Completed</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="no-quizzes">No quizzes assigned yet.</p>
    <?php endif; ?>
</div>

</body>
</html>
