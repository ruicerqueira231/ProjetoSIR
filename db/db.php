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


<!--

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


function mysqli_connect_mysql() {
    $servername = "sql105.infinityfree.com"; // Database server name
    $dbUsername = "if0_35800171"; // Database username
    $dbPassword = "2910Evt!"; // Database password
    $dbName = "if0_35800171_eventhubdb"; // Database name

    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
 -->