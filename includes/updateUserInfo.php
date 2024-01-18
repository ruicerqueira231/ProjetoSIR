<?php
require_once '../db/db.php'; // Adjust path as needed
$conn = mysqli_connect_mysql();

session_start();

// Check if user is logged in
if (!isset($_SESSION['userId'])) {
    header("location: ../login.php");
    exit();
}

$userId = $_SESSION['userId'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract and sanitize form data
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];

    // Check if the email is already taken by another user
    $emailCheck = $conn->prepare("SELECT id_user FROM tb_user WHERE email = ? AND id_user != ?");
    $emailCheck->bind_param("si", $email, $userId);
    $emailCheck->execute();
    $emailCheckResult = $emailCheck->get_result();
    if ($emailCheckResult->num_rows > 0) {
        header("location: ../Error/emailTaken.php");
        exit;
    }
    $emailCheck->close();

    // Check if the old password is correct
    $passwordCheck = $conn->prepare("SELECT password FROM tb_user WHERE id_user = ?");
    $passwordCheck->bind_param("i", $userId);
    $passwordCheck->execute();
    $passwordResult = $passwordCheck->get_result();
    $user = $passwordResult->fetch_assoc();
    if (!password_verify($oldPassword, $user['password'])) {
        header("location: ../Error/oldPasswordIncorrect.php");
        exit;
    }
    $passwordCheck->close();

    // Hash the new password if it is being changed
    if (!empty($newPassword) && $newPassword === $confirmNewPassword) {
        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    } else {
        header("location: ../Error/passwordMismatch.php");
        exit;
    }

    // Update user info in the database
    $updateStmt = $conn->prepare("UPDATE tb_user SET name = ?, email = ?, phone = ?, password = ? WHERE id_user = ?");
    $updateStmt->bind_param("ssssi", $name, $email, $phone, $hashedNewPassword, $userId);
    if ($updateStmt->execute()) {
        echo "User information updated successfully.";
        header("location: ../Error/changeSuccess.php"); // Redirect to the dashboard
    } else {
        header("location: ../Error/changeError.php");
    }
    $updateStmt->close();
}

$conn->close();
?>
