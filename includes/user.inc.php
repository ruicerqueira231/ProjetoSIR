<?php

function getAllUsers($conn, $excludeUserId) {
    $sql = "SELECT id_user, name FROM tb_user WHERE id_user != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $excludeUserId);
    $stmt->execute();
    $result = $stmt->get_result();

    $users = array();
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    } else {
        echo "0 results";
    }
    return $users;
}

