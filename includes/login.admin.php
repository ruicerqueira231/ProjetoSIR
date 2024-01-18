<?php

require_once '../db/db.php';
require_once 'loginFunction.admin.php';

if (isset($_POST["submit"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    if(emptyInputLogin($username, $password) !== false){
        header("location: ../login.php?error=emptyinput");
        exit();
    }

    loginUser($conn , $username, $password);
} else{
    header("location: ../adminLogin.php");
    exit();
}