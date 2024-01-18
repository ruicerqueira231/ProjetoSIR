<?php
function loginUser($conn, $username, $password) {
    // SQL query to get user by username
    $sql = "SELECT * FROM tb_admin WHERE username=?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        header("location: ../login.php?error=sqlerror");
        exit();
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Check if the password matches
        $pwdCheck = password_verify($password, $row['password']);
        if ($pwdCheck == false) {
            // Wrong password
            header("location: ../Error/invalidCredentialsA.php");
            exit();
        } else if ($pwdCheck == true) {
            // Login success
            session_start();
            $_SESSION['adminId'] = $row['id_admin'];
            $_SESSION['adminUsername'] = $row['username'];

            header("location: ../admin.php");
            exit();
        }
    } else {
        // No user found
        header("location: ../Error/noAdminFound.php");
        exit();
    }

    $stmt->close();
}
?>
