<?php
    require_once '../db/db.php';
    $conn = mysqli_connect_mysql();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Extract and sanitize form data
        $username = $conn->real_escape_string($_POST['username']);
        $password = $conn->real_escape_string($_POST['password']);

        // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new admin into the database
    $stmt = $conn->prepare("INSERT INTO tb_admin (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashedPassword);
    if ($stmt->execute()) {
        echo "<script>alert('New admin created successfully');</script>";
        // Redirect back to admin dashboard or wherever appropriate
        header("Location: ../admin.php");
    } else {
        echo "<script>alert('Error: could not create admin');</script>";
    }
    $stmt->close();
        }

    $conn->close();
?>
