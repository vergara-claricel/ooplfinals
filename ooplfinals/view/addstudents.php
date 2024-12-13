<?php
include('../classes/conn.php');
include ('../classes/student.php');
include('../classes/teacher.php');
include('../partials/header.php');

$quiz_id = $_GET['quizid'];

// Fetch existing students already added to the quiz
$stmt = $connection->prepare("SELECT student_id FROM quiz_students WHERE quiz_id = ?");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$result = $stmt->get_result();
$existing_students = [];
while ($row = $result->fetch_assoc()) {
    $existing_students[] = $row['student_id'];
}

// Handle saving selected students
if (isset($_POST['savestudent'])) {
    $selected_students = $_POST['students_list'];
    $userId = $_GET['id'];

    $qs = new Teacher();

    foreach ($selected_students as $userid) {
        if (!in_array($userid, $existing_students)) {
            $qs->selectQuizStudents($quiz_id, $userid);
        }
    }

    header("Location: /ooplfinals/view/addquestions.php?id=$userId&quizid=$quiz_id");
}


$studentz = new Student();
$students_by_section = $studentz->getStudentsGroupedBySection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Students for Quiz</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
            margin-bottom: 20px;
        }

        .section-checkbox {
            margin-right: 10px;
        }

        .student-checkbox {
            margin-left: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
            display: block;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
        }

        .student-section {
            margin-bottom: 30px;
        }

        .student-section label {
            display: block;
            font-size: 16px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Select Students for the Quiz</h2>

    <form method="post">
        <?php 
        foreach ($students_by_section as $section => $students) {
            echo '<div class="student-section">';
            echo '<label><input type="checkbox" class="section-checkbox"> ' . $section . '</label>';
            
            foreach ($students as $student) {
                $disabled = in_array($student['user_id'], $existing_students) ? 'disabled' : '';
                $checked = in_array($student['user_id'], $existing_students) ? 'checked' : '';
                
                echo '<label style="margin-left: 20px;">';
                echo '<input type="checkbox" name="students_list[]" value="' . $student['user_id'] . '" class="student-checkbox" ' . $disabled . ' ' . $checked . '> ';
                echo $student['name'] . ' - ' . $section;
                echo '</label>';
            }

            echo '</div>';
        }
        ?>

        <button type="submit" name="savestudent">Save Selected Students</button>
    </form>
</div>

<script>
    document.querySelectorAll('.section-checkbox').forEach(sectionCheckbox => {
        sectionCheckbox.addEventListener('change', function() {
            const sectionDiv = this.closest('.student-section');
            const studentCheckboxes = sectionDiv.querySelectorAll('.student-checkbox');
            studentCheckboxes.forEach(studentCheckbox => {
                if (!studentCheckbox.disabled) {
                    studentCheckbox.checked = this.checked;
                }
            });
        });
    });
</script>

</body>
</html>
