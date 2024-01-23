<?php
function createNote($conn, $eventId, $userId, $noteText) {
    // Validate the input
    if (empty($noteText)) {
        echo "Note text cannot be empty.";
        return false;
    }

    // Get the current date and time
    $currentDate = date('Y-m-d'); // Current date in 'YYYY-MM-DD' format
    $currentTime = date('H:i:s'); // Current time in 'HH:MM:SS' format

    // Prepare SQL statement to insert the note into the database
    $sql = "INSERT INTO tb_note (note, date_note, hora_note, id_user, id_event) VALUES (?, ?, ?, ?, ?);";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "<h4>SQL statement failed.</h4>";
        return false;
    }

    mysqli_stmt_bind_param($stmt, "ssiii", $noteText, $currentDate, $currentTime, $userId, $eventId);
    if(mysqli_stmt_execute($stmt)) {
        $note_id = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt);
        return $note_id;
    } else {
        echo "Error: Could not create note.";
        mysqli_stmt_close($stmt);
        return false;
    }
}

function getNotes($conn, $eventId) {
    $sql = "SELECT * FROM tb_note WHERE id_event = ? ORDER BY date_note DESC, hora_note DESC";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "SQL statement failed.";
        return false;
    }

    // Bind parameters and execute the statement
    mysqli_stmt_bind_param($stmt, "i", $eventId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $notes = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $notes[] = $row;
    }

    mysqli_stmt_close($stmt);

    return $notes;
}

function deleteNote($conn, $noteId, $userId, $eventId) {
    $sql = "DELETE FROM tb_note WHERE id_note = ? AND id_user = ? AND id_event = ?";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "SQL statement failed.";
        return false;
    }

    mysqli_stmt_bind_param($stmt, "iii",$noteId, $userId, $eventId);
    if(mysqli_stmt_execute($stmt)){
        return true;
    }else{
        return false;
    }
}