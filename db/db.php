<?php
function mysqli_connect_mysql() {
    $servername = "localhost";
    $dbUsername = "root"; // or your database username
    $dbPassword = ""; // or your database password
    $dbName = "evenhubdb";

    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?>