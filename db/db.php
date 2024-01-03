<?php

function mysqli_connect_mysql(){
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'evenhubdb';


$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if(!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

return $conn;
}
?>