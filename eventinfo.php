<?php
session_start();
require_once 'db/db.php';
require_once 'includes/event.inc.php';
require_once 'includes/user.inc.php';
require_once 'includes/invite.inc.php';
require_once 'includes/attachement.inc.php';
require_once 'includes/note.inc.php';

$event = null;
$conn = mysqli_connect_mysql();
$userId = $_SESSION['userId'] ?? null;

if (!$userId) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $eventId = $_GET['id'];
    $event = getEventById($conn, $eventId);
    $notes = getNotes($conn, $eventId);
    $users = getAllUsers($conn, $userId);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editEvent'])) {
    $eventId = $_POST['eventId'];
    $name = $_POST['eventName'];
    $localizacao = $_POST['eventLocation'];
    $data = $_POST['eventDate'];
    $hora = $_POST['eventTime'];
    $id_category = $_POST['category'];

    if (editEvent($conn, $eventId, $userId, $name, $localizacao, $data, $hora, $id_category)) {
        header("Location: eventinfo.php?id=$eventId");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteEventId'])) {
    $deleteEventId = $_POST['deleteEventId'];

    if (deleteEvent($conn, $deleteEventId)) {
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Failed to delete the event.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sendInvite'])) {
    $inviteeId = $_POST['invitee'];
    $eventId = $_POST['eventId'];

    if (sendInvite($conn, $userId, $inviteeId, $eventId)) {
        header("Location: eventinfo.php?id=$eventId");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['createAttachment'])) {
    $eventId = $_POST['eventId'];
    if (createAttachment($conn, $eventId, $userId, $_FILES['attachmentFile'])) {
        header("Location: eventinfo.php?id=$eventId");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['createNote'])) {
    $eventId = $_POST['eventId'];
    $noteText = $_POST['noteText'];

    if (createNote($conn, $eventId, $userId, $noteText)) {
        header("Location: eventinfo.php?id=$eventId");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteNote'])) {
    $noteId = $_POST['noteId'];
    $eventId = $_POST['eventId'];

    if (deleteNote($conn, $noteId, $userId, $eventId)) {
        header("Location: eventinfo.php?id=$eventId");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteAttachment'])) {
    $attachmentId = $_POST['attachmentId'];
    $eventId = $_POST['eventId'];

    if (deleteAttachment($conn, $attachmentId, $userId, $eventId)) {
        header("Location: eventinfo.php?id=$eventId");
        exit;
    }
}

$attachments = getAllAttachment($conn, $eventId);

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- other head elements -->
</head>
<body>

<?php require 'navbar.php';?>

<div class="container my-4">
    <div class="card shadow">
        <div class="card-body">
            <?php if ($event): ?>
                <h2 class="card-title"><?php echo htmlspecialchars($event['name']); ?></h2>
                <p class="card-text"><strong>Location:</strong> <?php echo htmlspecialchars($event['localizacao']); ?></p>
                <p class="card-text"><strong>Date:</strong> <?php echo htmlspecialchars($event['date_event']); ?></p>
                <p class="card-text"><strong>Time:</strong> <?php echo htmlspecialchars($event['hora']); ?></p>
            <?php else: ?>
                <div class="alert alert-danger" role="alert">
                    Event not found.
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-between my-3">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editEventModal">Edit Event</button>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteEventModal">Delete Event</button>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createInvitationModal">Create Invitation</button>
            </div>
        </div>
    </div>

    <form action="eventinfo.php" method="post" enctype="multipart/form-data" class="my-4">
        <input type="hidden" name="eventId" value="<?php echo htmlspecialchars($event['id_event']); ?>">
        <div class="mb-3">
            <label for="attachmentFile" class="form-label">Attachment:</label>
            <input type="file" class="form-control" name="attachmentFile" id="attachmentFile">
        </div>
        <button type="submit" class="btn btn-primary" name="createAttachment">Upload Attachment</button>
    </form>

    <div class="attachments">
    <h3>Attachments</h3>
    <?php if (!empty($attachments)): ?>
        <div class="list-group">
            <?php foreach ($attachments as $attachment): ?>
                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <?php echo htmlspecialchars($attachment['attachement']); ?>
                    <div>
                        <a href="/SIR/uploads/<?php echo htmlspecialchars($attachment['attachement']); ?>" class="btn btn-primary btn-sm" target="_blank">View</a>
                        <?php
                        if ($_SESSION['userId'] == $attachment['id_user']) {
                        ?>
                            <!-- Delete Button -->
                            <form action="eventinfo.php" method="post" class="d-inline">
                                <input type="hidden" name="attachmentId" value="<?php echo htmlspecialchars($attachment['id_attachement']); ?>">
                                <input type="hidden" name="eventId" value="<?php echo htmlspecialchars($eventId); ?>">
                                <button type="submit" name="deleteAttachment" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        <?php
                        }
                        ?>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-muted">No attachments available.</p>
    <?php endif; ?>
</div>


    <button type="button" class="btn mt-5 btn-primary" data-bs-toggle="modal" data-bs-target="#addNoteModal">
        Add Note
    </button>

    <div class="mt-4">
        <h3>Notes</h3>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php if (!empty($notes)): ?>
                <?php foreach ($notes as $note): ?>
                    <div class="col">
                        <div class="card h-100 position-relative">
                            <div class="card-body">
                                <h5 class="card-title">Note</h5>
                                <p class="card-text"><?php echo htmlspecialchars($note['note']); ?></p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Date: <?php echo htmlspecialchars($note['date_note']); ?> Time: <?php echo htmlspecialchars($note['hora_note']); ?></small>
                            </div>
                            <?php
                            if ($_SESSION['userId'] == $note['id_user']) {
                            ?>
                                <!-- Delete Button -->
                                <form action="eventinfo.php" method="post" class="position-absolute top-0 end-0 m-2">
                                    <input type="hidden" name="noteId" value="<?php echo htmlspecialchars($note['id_note']); ?>">
                                    <input type="hidden" name="eventId" value="<?php echo htmlspecialchars($eventId); ?>">
                                    <button type="submit" name="deleteNote" class="btn btn-danger btn-sm" title="Delete Note">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </form>
                            <?php
                            }
                            ?>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col">
                    <p>No notes available.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    </div>


    <!-- Modal para editar evento -->
    <div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEventModalLabel">Edit Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="eventinfo.php?id=<?php echo htmlspecialchars($eventId); ?>" method="post">
                        <input type="hidden" id="eventId" name="eventId" value="<?php echo htmlspecialchars($event['id_event']); ?>">

                        <div class="form-group">
                            <label for="eventName">Event Name:</label>
                            <input type="text" class="form-control" id="eventName" name="eventName" value="<?php echo htmlspecialchars($event['name']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="eventLocation">Location:</label>
                            <input type="text" class="form-control" id="eventLocation" name="eventLocation" value="<?php echo htmlspecialchars($event['localizacao']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="eventDate">Date:</label>
                            <input type="date" class="form-control" id="eventDate" name="eventDate" value="<?php echo htmlspecialchars($event['date_event']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="eventTime">Time:</label>
                            <input type="time" class="form-control" id="eventTime" name="eventTime" value="<?php echo htmlspecialchars($event['hora']); ?>">
                        </div>
                        <button type="submit" class="btn btn-primary" name="editEvent">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para eliminar evento -->
    <div class="modal fade" id="deleteEventModal" tabindex="-1" aria-labelledby="deleteEventModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteEventModalLabel">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this event?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="eventinfo.php" method="post">
                            <input type="hidden" name="deleteEventId" value="<?php echo $eventId; ?>">
                            <button type="submit" class="btn btn-danger">Delete Event</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <!-- Create Invitation Modal -->
    <div class="modal fade" id="createInvitationModal" tabindex="-1" aria-labelledby="createInvitationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createInvitationModalLabel">Create Invitation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="eventinfo.php" method="post">
                        <div class="mb-3">
                            <label for="invitee" class="form-label">Select User to Invite:</label>
                            <select class="form-select" id="invitee" name="invitee">
                                <?php foreach ($users as $user): ?>
                                    <option value="<?php echo htmlspecialchars($user['id_user']); ?>">
                                        <?php echo htmlspecialchars($user['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <input type="hidden" name="eventId" value="<?php echo htmlspecialchars($eventId); ?>">
                        <button type="submit" class="btn btn-primary" name="sendInvite">Send Invitation</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Note Modal -->
    <div class="modal fade" id="addNoteModal" tabindex="-1" aria-labelledby="addNoteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNoteModalLabel">Add Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="eventinfo.php?id=<?php echo htmlspecialchars($eventId); ?>" method="post">
                        <div class="mb-3">
                        <input type="hidden" name="eventId" value="<?php echo htmlspecialchars($event['id_event']); ?>">
                            <label for="noteText" class="form-label">Note:</label>
                            <textarea class="form-control" id="noteText" name="noteText" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="createNote">Submit Note</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>

</body>
</html>
