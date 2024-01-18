<?php

function emptyInputs($name, $phone, $email, $username, $password, $passwordRepeat, $securityQuestion) {
    if(empty($name) || empty($phone) || empty($email) || empty($username) || empty($password) || empty($passwordRepeat) || empty($securityQuestion)) {
        return true;
    } else {
        return false;
    }
}

function invalidUsername($username) {
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        return true;
    } else {
        return false;
    }
}

function invalidPhone($phone) {
    if(preg_match('/^[0-9]{10}+$/', $phone)) {
        return true;
    } else {
        return false;
    }
}

function invalidEmail($email) {
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

function passMatch($password, $passwordRepeat) {
    if( $password !== $passwordRepeat) {
        return true;
    } else {
        return false;
    }
}

function usernameExists($conn, $username) {
    $query = "SELECT * FROM tb_user WHERE username = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../register.php?error=stmterror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($resultData);
    mysqli_stmt_close($stmt);

    if ($row) {
        return $row;
    } else {
        return false;
    }
}

function emailExists($conn, $email) {
    $query = "SELECT * FROM tb_user WHERE email = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../register.php?error=stmterror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($resultData);
    mysqli_stmt_close($stmt);

    if ($row) {
        return $row; 
    } else {
        return false; 
    }
}

function createUser($conn, $name, $phone, $email, $username, $password, $securityQuestion) {
    $query = "INSERT INTO tb_user (name, phone, email, username, password, security_question) VALUES (?, ?, ?, ?, ?, ?);";
    $conn->query("UPDATE statistics SET stat_value = stat_value + 1 WHERE stat_name = 'accounts_created'"); // +1 estatistica
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../register.php?error=stmterror");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssssss", $name, $phone, $email, $username, $hashedPassword, $securityQuestion);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../login.php");
    exit();
}


