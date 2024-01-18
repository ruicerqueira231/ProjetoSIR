<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['userId'])) {
    session_destroy();
}

// Redirect the user to the login page
header("location: login.php");
exit();
?>
