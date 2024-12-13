<?php
// include ('./partials/header.php');
include ('../ooplfinals/classes/conn.php');
include ('../ooplfinals/classes/user.php');

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    $customer = new User($username, $password, $user_type);
    $user = $customer->login();

    if($user){
        // $_SESSION['username'] = $username;
        $userId = $user['user_id']; 
        $_SESSION['id'] = $userId;
        if ($user_type == 'student') {
            header("Location: /ooplfinals/view/studentdashboard.php?id=$userId");
        } else if ($user_type == 'teacher') {
            header("Location: /ooplfinals/view/teacherdashboard.php?id=$userId");
        }

    }
}
?>
<link rel="stylesheet" href="../ooplfinals/css/style.css">
<div class="logincontainer">
    <form method="POST">
    <label for="username">username</label>
    <input type="text" name="username" required>
    <label for="password">password</label>
    <input type="password" name="password"required>
    
    <div class="usertype">
    <input type="radio" name="user_type" value="student"> 
    <label for="student">student</label>

    <input type="radio" name="user_type" value="teacher">
    <label for="teacher">teacher</label>
    </div>

    <input type="submit" name="login"></button>
    </form>
</div>


