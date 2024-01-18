<?php

require_once 'db/db.php'; 
require_once 'includes/event.inc.php';
require_once 'includes/invite.inc.php';

if (!isset($_SESSION['userId'])) {
    header("location: login.php");
    exit();
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("location: login.php");
    exit();
}

// Create database connection
$conn = mysqli_connect_mysql();

// Check if the image URL update form was submitted
if (isset($_POST['imageUrl'])) {
    $newImageUrl = $_POST['imageUrl'];
    $userId = $_SESSION['userId'];

    // Prepare and execute update query
    $updateStmt = $conn->prepare("UPDATE tb_user SET image_url = ? WHERE id_user = ?");
    $updateStmt->bind_param("si", $newImageUrl, $userId);

    if ($updateStmt->execute()) {
        // Success message or logic
    } else {
        // Error handling
    }

    $updateStmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acceptInvite'])) {
    $inviteId = $_POST['inviteId'];

    acceptInvite($conn, $inviteId);
    header('location: dashboard.php'); 
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['rejectInvite'])) {
    $inviteId = $_POST['inviteId'];
    rejectInvite($conn, $inviteId);
    header('location: dashboard.php'); 
    exit();
}


//FETCH USER INFO E IMAGEM
$user_id = $_SESSION['userId'];
$query = "SELECT name, image_url FROM tb_user WHERE id_user = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    $name = $user['name'];
    $image_url = $user['image_url'] ?: 'assets/defaultuser.png';
} else {
    $name = "Unknown";
    $image_url = 'assets/defaultuser.png';
}

// FETCH USER ID COUNT
$userCount = 0;
$countQuery = "SELECT COUNT(id_user) AS userCount FROM tb_user";
$countResult = $conn->query($countQuery);
if ($countResult) {
    $row = $countResult->fetch_assoc();
    $userCount = $row['userCount'];
}


$invitations = viewInvitations($conn, $_SESSION['userId']);

$stmt->close();
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link href="css/dashboard.css" rel="stylesheet">
</head>
<body>

<div class="container-fluid">
    <!-- Horizontal Navbar -->
    <div class="row">
        <nav class="navbar navbar-expand-lg navbar-light bg-warning">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <!-- User Info -->
                    <ul class="navbar-nav me-auto align-items-center">
                        <li class="nav-item">
                            <img src="<?php echo htmlspecialchars($image_url); ?>" alt="User Image" class="profile-picture"
                                data-bs-toggle="modal" data-bs-target="#imageModal">
                        </li>
                        <li class="nav-item">
                            <p class="user-name">
                                <?php echo htmlspecialchars($name); ?>
                            </p>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="dashboard.php" class="btn btn-custom me-2">
                                <i class="fas fa-tachometer-alt fa-fw me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <button class="btn btn-custom me-2" data-bs-toggle="modal"
                                data-bs-target="#notificationsModal">
                                <i class="fas fa-bell fa-fw me-2"></i>Notifications
                            </button>
                        </li>
                    </ul>

                    <!-- Settings and Logout -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <button type="button" class="btn btn-custom me-2" data-bs-toggle="modal" data-bs-target="#activeUsersModal">
                                <i class="fas fa-users fa-fw"></i> Active Users on our Website:
                                <?php echo $userCount; ?>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button id="sidebarSettingsButton" class="btn btn-custom me-2" data-bs-toggle="modal"
                                data-bs-target="#settingsModal">
                                <i class="fas fa-cog fa-fw"></i>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="btn btn-custom me-2" data-bs-toggle="modal"
                                data-bs-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-fw"></i>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>




    <!-- Settings Modal -->
    <div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="settingsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="settingsModalLabel">Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <hr>
                <div class="modal-body">

                    <!-- NIGHT MODE CHECK BOX -->
                    <div class="form-check modal-option">
                        <input class="form-check-input" type="checkbox" id="nightModeCheckbox">
                        <label class="form-check-label" for="nightModeCheckbox">
                            Enable Night Mode
                        </label>
                    </div>
                    <hr>
                    <!-- PROFILE image URL -->
                    <form action="/sir/includes/img_update_script.php" method="post">
                        <div class="mb-3 modal-option">
                            <label for="imageUrl" class="form-label">Profile Image Update</label>
                            <input type="text" class="form-control" id="imageUrl" name="imageUrl"
                                placeholder="Enter image URL (must end in .png)">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Image</button>
                    </form>
                    <hr>
                    <!-- CHANGE INFO -->
                    <div class="mb-3">
                        <div class="mb-2">
                            <label for="changeUserInfoLabel" class="form-label">Change User Info</label>
                        </div>
                        <div>
                            <a href="changeUserInfo.php" class="btn btn-primary">Change Info</a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveSettingsButton">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Notifications Modal -->
    <div class="modal fade" id="notificationsModal" tabindex="-1" aria-labelledby="notificationsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationsModalLabel">Notifications</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php foreach ($invitations as $invitation): ?>
                        <div class="card mb-3" id="invite-<?php echo $invitation['id_invite']; ?>">
                            <div class="card-body">
                                <h5 class="card-title">Invitation from User ID: <?php echo htmlspecialchars($invitation['id_user']); ?></h5>
                                <p>For Event ID: <?php echo htmlspecialchars($invitation['id_event']); ?></p>
                                <?php if ($invitation['estado'] === 'accepted'): ?>
                                    <button class="btn btn-secondary" disabled>Accepted</button>
                                <?php elseif ($invitation['estado'] === 'rejected'): ?>
                                    <button class="btn btn-secondary" disabled>Rejected</button>
                                <?php else: ?>
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="display: inline;">
                                        <input type="hidden" name="inviteId" value="<?php echo $invitation['id_invite']; ?>">
                                        <button type="submit" class="btn btn-success" name="acceptInvite">Accept</button>
                                    </form>
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="display: inline;">
                                        <input type="hidden" name="inviteId" value="<?php echo $invitation['id_invite']; ?>">
                                        <button type="submit" class="btn btn-danger" name="rejectInvite">Reject</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>




    <!-- Active Users Modal -->
    <div class="modal fade" id="activeUsersModal" tabindex="-1" aria-labelledby="activeUsersModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="activeUsersModalLabel">Active Users</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Total active users on our website:
                    <?php echo $userCount; ?>
                </div>
            </div>
        </div>
    </div>

        <!-- Image Modal -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">User Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="" id="modalImage" class="img-fluid" alt="User Image">
                </div>
            </div>
        </div>
    </div>

        <!-- Logout Confirmation Modal -->
        <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to logout?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="logout.php" class="btn btn-primary">Logout</a>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="js/dashboard.js"></script>
</body>
</html>