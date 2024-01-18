<?php

function sendInvite($conn, $inviter_id, $invitee_id, $event_id) {
    $status = 'sent'; 
    $sql = "INSERT INTO tb_invite (estado, id_user, id_user_convidado, id_event) VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    // Correct the order of parameters to match the SQL statement
    $stmt->bind_param("siii", $status, $inviter_id, $invitee_id, $event_id);

    if ($stmt->execute()) {
        $stmt->close();
        return true; // Success
    } else {
        $stmt->close();
        return false; // Failure
    }
}



function viewInvitations($conn, $invitee_id) {
    $sql = "SELECT * FROM tb_invite WHERE id_user_convidado = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $invitee_id);

    $invitations = [];
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $invitations[] = $row;
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    return $invitations;
}


function acceptInvite($conn, $invite_id) {
    // Update tb_invite status to accepted
    $response = 'accepted';
    $sql = "UPDATE tb_invite SET estado = ? WHERE id_invite = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $response, $invite_id);

    if (!$stmt->execute()) {
        echo "Error: " . $stmt->error;
        return;
    }

    // Fetch invitee and event details
    $sql = "SELECT id_user_convidado, id_event FROM tb_invite WHERE id_invite = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $invite_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $invitee_id = $row['id_user_convidado']; 
    $event_id = $row['id_event'];

    // Insert into tb_participacao
    $sql = "INSERT INTO tb_participacao (id_user, id_event) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $invitee_id, $event_id); 
    $stmt->execute();
    $stmt->close();
}

function rejectInvite($conn, $invite_id) {
    // Update tb_invite status to rejected
    $response = 'rejected';
    $sql = "UPDATE tb_invite SET estado = ? WHERE id_invite = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $response, $invite_id);

    if (!$stmt->execute()) {
        echo "Error: " . $stmt->error;
        return false;
    }

    $stmt->close();
    return true;
}



