<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['adminId'])) {
    session_destroy();
}

// Redirect the user to the login page
header("location: adminLogin.php");
exit();
?>
