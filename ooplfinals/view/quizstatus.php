<?php
include('../classes/conn.php');
include('../partials/header.php');
include('../classes/quizresults.php');

$quizId = $_GET['quizid'];
$userId = $_GET['id'];

// Use the getAttemptTime method to get the results
$qrobj = new QuizResults();
$timeresult = $qrobj->getAttemptTime($quizId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Status</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            display: inline-block;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #007bff;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .status {
            font-weight: bold;
        }

    </style>
</head>
<body>

<div class="container">
    <h2>Student Status for Quiz ID: <?php echo $quizId; ?></h2>

    <table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Section</th>
            <th>Status</th>
            <th>Score</th>
            <th>Date and Time Taken</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = $timeresult->fetch_assoc()) {
            // Check if score exists to determine if quiz was taken
            $status = $row['score'] !== null ? 'Taken' : 'Not Taken';
            $score = $row['score'] !== null ? $row['score'] : 'N/A';
            $attemptedAt = $row['attempt_at'] ? date("Y-m-d H:i:s", strtotime($row['attempt_at'])) : 'N/A';

            echo "<tr>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['section'] . "</td>
                    <td class='status'>" . $status . "</td>
                    <td>" . $score . "</td>
                    <td>" . $attemptedAt . "</td>
                  </tr>";
        }
        ?>
    </tbody>
</table>

    <form method="post">
        <button type="submit" name="addstudents" class="btn">Add Students</button>
    </form>

    <a href="/ooplfinals/view/teacherdashboard.php?id=<?php echo $userId; ?>" class="back-link">Back to Dashboard</a>
</div>

</body>
</html>
