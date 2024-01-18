<?php
session_start();

// Check if the user is already logged in, redirect to index.php if true
if (isset($_SESSION['userId'])) {
    header("location: dashboard.php");
    exit();
}

// Include your database connection script
require_once 'db/db.php'; // Adjust the path as needed

// Include the script where loginUser function is defined
require_once 'includes/loginFunction.inc.php';

// When login form is submitted
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $conn = mysqli_connect_mysql();
    loginUser($conn, $username, $password);
}

// When forgot password form is submitted
if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Validate the email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit;
    }

    // Connect to database
    $conn = mysqli_connect_mysql();

    // Check if the email exists in your database
    // This is a placeholder query, adjust according to your database structure
    $query = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        echo "No account found with that email.";
        exit;
    }
    $user = $result->fetch_assoc();



}


?>



<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <style>
            html,
            body {
                height: 100%;
                margin: 0;
                padding: 0;
                overflow-x: hidden;
            }

            body {
                background-image: url('assets/background-login-image.jpg');
                background-size: cover;
                background-position: center center;
                background-repeat: no-repeat;
                background-attachment: fixed;

                -webkit-backdrop-filter: blur(5px);
                backdrop-filter: blur(5px);
            }

            .card {
                box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.2);
            }

            .btn-primary {
                background-color: #f0ad4e;
                border-color: #f0ad4e;
            }

            .btn-primary:hover,
            .btn-primary:focus,
            .btn-primary:active {
                background-color: #ec971f;
                border-color: #ec971f;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="row justify-content-center align-items-center vh-100">
                <div class="col-md-6 col-lg-4">
                    <div class="card d-flex">
                    <a href="index.php" class="d-block text-center">
                        <img src="assets/image-logo-black.png" alt="Your Logo" class="card-img-top" style="width: 30%; margin-top: 20px;">
                    </a>
                        <h1 class="mb-4 text-center">Login to EventHub</h1>
                        <div class="card-body">
                            <form action="login.php" method="POST">
                                <div class="mb-3">
                                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                                </div>
                                <div class="mb-3">
                                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                                </div>
                                <div class="mb-3 form-check">
                                    <input class="form-check-input" type="checkbox" id="formCheck">
                                    <label class="form-check-label" for="formCheck">Remember me?</label>
                                </div>
                                <div class="mb-3 text-center">
                                    <button type="submit" name="submit" class="btn btn-primary me-2">Login</button>
                                    <a href="register.php" class="btn btn-secondary">Register</a>
                                </div>
                                <div class="mb-3 text-center">
                                    <!--<a href="#" class="link-secondary" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">Forgot Password?</a>-->
                                    <a href="forgotpasswordmail.php" class="link-secondary">Forgot Password?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>





        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"></script>
        <script src="js/login.js"></script>
    </body>

</html>