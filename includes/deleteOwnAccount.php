<?php
require_once '../db/db.php'; // Adjust the path as needed
$conn = mysqli_connect_mysql();

session_start();

if (isset($_SESSION['adminId'])) {
    $adminId = $_SESSION['adminId'];

    // Prepare and execute the delete query using 'id_admin' as the column name
    $stmt = $conn->prepare("DELETE FROM tb_admin WHERE id_admin = ?");
    $stmt->bind_param("i", $adminId);

    if ($stmt->execute()) {
        // Destroy session and redirect to login page or home page
        session_destroy();
        header("Location: ../adminLogin.php?account_deleted=success");
    } else {
        // Redirect back with an error message
        header("Location: ../adminDashboard.php?account_deleted=error");
    }
    $stmt->close();
}

$conn->close();
?>
