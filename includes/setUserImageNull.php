<?php
require_once '../db/db.php';
$conn = mysqli_connect_mysql();

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Prepare and execute update query
    $stmt = $conn->prepare("UPDATE tb_user SET image_url = NULL WHERE id_user = ?");
    $stmt->bind_param("i", $userId);
    if ($stmt->execute()) {
        // Redirect back to admin dashboard with a success message
        header("Location: ../admin.php?setimage=nullsuccess");
    } else {
        // Redirect back to admin dashboard with an error message
        header("Location: ../admin.php?setimage=nullerror");
    }
    $stmt->close();
}

$conn->close();
?>
