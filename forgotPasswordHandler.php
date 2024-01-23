<?php
require_once 'db/db.php';

function checkSecurityAnswer($conn, $email, $securityAnswer) {
    $stmt = $conn->prepare("SELECT * FROM tb_user WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $user['security_question'] === $securityAnswer) {
        return true;
    } else {
        return false;
    }
}

function updatePassword($conn, $email, $newPassword) {
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE tb_user SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashedPassword, $email);
    return $stmt->execute();
}

if (isset($_POST['email'], $_POST['securityAnswer'], $_POST['newPassword'])) {
    $email = $_POST['email'];
    $securityAnswer = $_POST['securityAnswer'];
    $newPassword = $_POST['newPassword'];

    $conn = mysqli_connect_mysql();

    if (checkSecurityAnswer($conn, $email, $securityAnswer)) {
        if (updatePassword($conn, $email, $newPassword)) {
            header("Location: passwordChangeSuccess.php");
            exit();
        } else {
            header("Location: updateFailed.php");
            exit();
        }
    } else {
        header("Location: invalidCredentials.php");
        exit();
    }
} else {
    header("Location: invalidAccess.php");
    exit();
}
?>
