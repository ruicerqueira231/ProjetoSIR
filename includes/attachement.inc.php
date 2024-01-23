<?php

function createAttachment($conn, $eventId, $userId, $file) {
    // Define the directory where files will be saved
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/SIR/uploads/';

    // Check if the uploads directory exists, if not create it
    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) {
        die("Failed to create upload directory.");
    }

    // Check if the file was uploaded without errors
    if (isset($file) && $file['error'] == UPLOAD_ERR_OK) {
        // Generate a unique file name
        $uniqueSuffix = time() . '-' . rand(1000, 9999);
        $safeFilename = $uniqueSuffix . '_' . preg_replace('/\s+/', '_', basename($file['name']));
        $targetFilePath = $uploadDir . $safeFilename;

        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            $sql = "INSERT INTO tb_attachement (attachement, id_event, id_user) VALUES (?, ?, ?);";

            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                return false;
            }

            mysqli_stmt_bind_param($stmt, "sii", $safeFilename, $eventId, $userId);
            mysqli_stmt_execute($stmt);
            $attachment_id = mysqli_insert_id($conn);
            mysqli_stmt_close($stmt);

            return $attachment_id;
        } else {
            echo "Error: Could not save file.";
            return false;
        }
    } else {
        echo "File upload error: " . $file['error'];
        return false;
    }
}


function getAllAttachment($conn, $eventId) {
    $sql = "SELECT * FROM tb_attachement WHERE id_event = ?";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "SQL statement preparation failed: " . mysqli_error($conn);
        return false;
    }

    mysqli_stmt_bind_param($stmt, "i", $eventId);

    if (!mysqli_stmt_execute($stmt)) {
        echo "Error executing statement: " . mysqli_stmt_error($stmt);
        return false;
    }

    $result = mysqli_stmt_get_result($stmt);
    $attachments = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt);

    return $attachments;
}

function deleteAttachment($conn,$attachementId, $userId, $eventId){
    $sql = "DELETE FROM tb_attachement WHERE id_attachement = ? AND id_user = ? AND id_event = ?";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "SQL statement failed.";
        return false;
    }

    mysqli_stmt_bind_param($stmt, "iii",$attachementId, $userId, $eventId);
    if(mysqli_stmt_execute($stmt)){
        return true;
    }else{
        return false;
    }
}


