<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['userId'])) {
    // Redirect to login page if not logged in
    header("location: ../login.php");
    exit();
}

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "evenhubdb";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the image URL form was submitted
if (isset($_POST['imageUrl'])) {
    $newImageUrl = $_POST['imageUrl'];
    $userId = $_SESSION['userId'];

    // Prepare and execute update query
    $updateStmt = $conn->prepare("UPDATE tb_user SET image_url = ? WHERE id_user = ?");
    $updateStmt->bind_param("si", $newImageUrl, $userId);

    if ($updateStmt->execute()) {
        // Optionally, add a success message or logic
    } else {
        // Optionally, add error handling logic
    }

    $updateStmt->close();
}

// Redirect back to the dashboard or the page with the modal
header("location: ../dashboard.php"); // Adjust the path as needed
exit();
?>
