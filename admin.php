<?php
session_start();

// Include your database connection script
require_once 'db/db.php';

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['adminId'])) {
    header("location: /sir/adminLogin.php");
    exit();
}

// Handle logout action
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("location: /sir/adminLogin.php");
    exit();
}

// Create database connection
$conn = mysqli_connect_mysql();


// FETCH USER ID COUNT
$userCount = 0;
$countQuery = "SELECT COUNT(id_user) AS userCount FROM tb_user"; // Replace 'tb_user' and 'id_user' with your actual table and column names
$countResult = $conn->query($countQuery);
if ($countResult) {
    $row = $countResult->fetch_assoc();
    $userCount = $row['userCount'];
}

//DELETE USER FETCH
$users = [];
$query = "SELECT id_user, email FROM tb_user";
$result = $conn->query($query);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

//DELETE POP UP SUCESS

if (isset($_GET['delete']) && $_GET['delete'] == 'success') {
    echo "<script>alert('User deleted successfully');</script>";
}


$conn->close();


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link href="css/dashboard.css" rel="stylesheet">
    <!-- Font Awesome for icons -->

</head>

<body>

    <div class="container-fluid">
        <!-- Horizontal Navbar -->
        <div class="row">
            <div class="col-12 bg-warning">
                <!-- Navbar content (previously in sidebar) -->
                <div class="d-flex justify-content-between align-items-center">
                    <!-- LOGO -->
                    <img src="assets/image-logo-black.png" alt="Your Logo" class="card-img-top" style="width: 10%; margin-top: 5px; margin-bottom: 5px;">
                    <h2 class=>Management Dashboard</h2>






                    <!-- Navbar Links/Buttons 
                    <div class="navbar-buttons-container">
                        <button class="btn btn-custom d-flex align-items-center">
                            <i class="fas fa-tachometer-alt fa-fw me-2"></i>Dashboard
                        </button>
                    </div>
                    -->



                    <!-- Settings and Logout -->
                    <div>
                        <button type="button" class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#activeUsersModal">
                            <i class="fas fa-users fa-fw"></i> Active Users on our Website:
                            <?php echo $userCount; ?>
                        </button>
                        <button id="sidebarSettingsButton" class="btn btn-custom" data-bs-toggle="modal"
                            data-bs-target="#settingsModal">
                            <i class="fas fa-cog fa-fw"></i>
                        </button>
                        <button type="button" class="btn btn-custom" data-bs-toggle="modal"
                            data-bs-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="row">
            <div class="col-12" id="page-content-wrapper">

                <!-- Delete User Button -->
                <button class="btn btn-danger my-3" data-bs-toggle="modal" data-bs-target="#deleteUserModal">Delete User</button>
                <hr>
                <!-- Create New Admin Button -->
                <button class="btn btn-success my-3" data-bs-toggle="modal" data-bs-target="#createAdminModal">Create New Admin</button>
                <hr>

            </div>
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
                <div class="modal-body">
                    <!-- NIGHT MODE CHECK BOX -->
                    <div class="form-check modal-option">
                        <input class="form-check-input" type="checkbox" id="nightModeCheckbox">
                        <label class="form-check-label" for="nightModeCheckbox">
                            Enable Night Mode
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveSettingsButton">Save changes</button>
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
                    <a href="adminLogout.php" class="btn btn-primary">Logout</a>
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

    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php foreach ($users as $user): ?>
                        <div class='d-flex justify-content-between align-items-center mb-2'>
                            <p class='mb-0'><?php echo htmlspecialchars($user['email']); ?></p>
                            <a href='includes/deleteUser.php?id=<?php echo $user['id_user']; ?>' class='btn btn-sm btn-danger'>Delete</a>
                        </div>
                        <?php if (next($users)): // Check if there is another user after the current one ?>
                            <hr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Create New Admin Modal -->
    <div class="modal fade" id="createAdminModal" tabindex="-1" aria-labelledby="createAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createAdminModalLabel">Create New Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="includes/createAdminScript.php" method="post">
                        <!-- Form fields for admin credentials -->
                        <div class="mb-3">
                            <label for="adminUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="adminUsername" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="adminPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="adminPassword" name="password" required>
                        </div>
                        <!-- Add other fields as necessary -->
                        <button type="submit" class="btn btn-primary">Create Admin</button>
                    </form>
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