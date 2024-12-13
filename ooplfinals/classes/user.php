<?php

require_once('conn.php');
$GLOBALS['connection'] = $connection;

class User{
    private $username;
    private $password;
    private $user_type;
    private $db;

    function __construct($username, $password, $user_type)
    {
        $this->username = $username;
        $this->password = $password;
        $this->user_type = $user_type;
        $this->db = $GLOBALS['connection'];
    }

    function login(){
        $q1 = "SELECT * from users where `username` = '$this->username' and `password` = '$this->password' and `user_type` = '$this->user_type'";
        $res = mysqli_query($this->db, $q1);
        $user = mysqli_fetch_assoc($res);
        return $user;
    }
}


?>