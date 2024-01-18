<?php

if (isset($_POST["submit"])){
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST['password'];
    $passwordRepeat = $_POST['passwordRepeat'];
    $securityQuestion = $_POST['securityQuestion'];

    require_once '../db/db.php';
    require_once 'functionsRegister.inc.php';

    $conn = mysqli_connect_mysql();

    if (emptyInputs($name, $phone, $email, $username, $password, $passwordRepeat, $securityQuestion) !== false) {
        header("location: ../register.php?error=emptyinput");
        exit();
    }

    if(invalidUsername($username) !== false){
        header("location: ../register.php?error=invalidUsername");
        exit();
    }

    if(invalidPhone($phone) !== false){
        header("location: ../register.php?error=invalidPhone");
        exit();
    }

    if(invalidEmail($email) !== false){
        header("location: ../register.php?error=invalidEmail");
        exit();
    }

    if(passMatch($password, $passwordRepeat) !== false){
        header("location: ../register.php?error=repeatedPass");
        exit();
    }

    if(usernameExists($conn, $username) !== false){
        header("location: ../register.php?error=usernameAlreadyExists");
        exit();
    }

    if(emailExists($conn, $username) !== false){
        header("location: ../register.php?error=emailAlreadyExists");
        exit();
    }
    

    createUser($conn, $name, $phone, $email, $username, $password, $securityQuestion);
}else{
    header("location: ../register.php");
}