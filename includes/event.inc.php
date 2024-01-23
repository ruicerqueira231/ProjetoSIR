<?php

function createEvent($conn, $name, $localizacao, $date_event, $hora, $id_category, $id_user_creator, $imageFileName) {
    $query = "INSERT INTO tb_event (name, localizacao, date_event, hora, id_category, id_user_creator, image_path) VALUES (?, ?, ?, ?, ?, ?, ?);";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $query)) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "ssssiss", $name, $localizacao, $date_event, $hora, $id_category, $id_user_creator, $imageFileName);
    mysqli_stmt_execute($stmt);

    $event_id = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);

    return $event_id;
}

function getCategories($conn) {
    $query = "SELECT * FROM tb_category;";
    $result = mysqli_query($conn, $query);

    $categories = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row;
        }
    }

    return $categories;
}

function getEventsByUserId($conn, $userId) {
    $query = "SELECT e.* FROM tb_event e
              JOIN tb_participacao p ON e.id_event = p.id_event
              WHERE p.id_user = ?";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $query)) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $events = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);

    return $events;
}

function getEventById($conn, $eventId) {
    $query = "SELECT * FROM tb_event WHERE id_event = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        echo 'Erro';
        return false;
    }

    $stmt->bind_param("i", $eventId);
    if (!$stmt->execute()) {
        echo 'erro';
        $stmt->close();
        return false;
    }

    $result = $stmt->get_result();
    $event = $result->fetch_assoc();
    $stmt->close();

    return $event ? $event : false;
}

function editEvent($conn, $eventId, $userId, $name, $localizacao, $data, $hora, $id_category) {
    //variavel que serve para confirmar user creator
    $checkQuery = "SELECT id_user_creator FROM tb_event WHERE id_event = ?";
    $checkStmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($checkStmt, $checkQuery)) {
        // Handle error
        return false;
    }
    mysqli_stmt_bind_param($checkStmt, "i", $eventId);
    mysqli_stmt_execute($checkStmt);
    $result = mysqli_stmt_get_result($checkStmt);
    $event = mysqli_fetch_assoc($result);
    mysqli_stmt_close($checkStmt);

    //verifica se o id do user é diferente do id do user creator (se for dá erro)
    if (!$event || $event['id_user_creator'] != $userId) {
        return false;
    }

    $updateQuery = "UPDATE tb_event SET name = ?, localizacao = ?, date_event = ?, hora = ?, id_category = ? WHERE id_event = ?";
    $updateStmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($updateStmt, $updateQuery)) {
        return false;
    }
    mysqli_stmt_bind_param($updateStmt, "ssssii", $name, $localizacao, $data, $hora, $id_category, $eventId);
    if (!mysqli_stmt_execute($updateStmt)) {
        mysqli_stmt_close($updateStmt);
        return false;
    }
    mysqli_stmt_close($updateStmt);

    return true;
}

function deleteEvent($conn, $event_id) {
    $query = "DELETE FROM tb_event WHERE id_event = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        echo "SQL statement failed";
        return false;
    } else {
        mysqli_stmt_bind_param($stmt, "i", $event_id);

        if (mysqli_stmt_execute($stmt)) {
            echo "Event deleted successfully";
            return true;
        } else {
            echo "Error deleting event";
            return false;
        }
    }
}