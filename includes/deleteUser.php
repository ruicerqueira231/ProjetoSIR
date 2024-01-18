<?php
require_once '../db/db.php';
$conn = mysqli_connect_mysql();

if (isset($_GET['id'])) {
    $userId = intval($_GET['id']);
    $deleteQuery = "DELETE FROM tb_user WHERE id_user = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();
    }
    
    $conn->close();
    header("Location: ../admin.php?delete=success"); // Redirect back to the admin dashboard
    exit();
?>