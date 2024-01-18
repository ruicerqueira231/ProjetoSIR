<?php
session_start();

// Check if the user is already logged in, redirect to index.php if true
if (isset($_SESSION['adminId'])) {
    header("location: admin.php");
    exit();
}

// Include your database connection script
require_once 'db/db.php'; // Adjust the path as needed

// Include the script where loginUser function is defined
require_once 'includes/loginFunction.admin.php';

// When login form is submitted
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $conn = mysqli_connect_mysql();
    loginUser($conn, $username, $password);
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
                        <h1 class="mb-4 text-center">Admin Login to EventHub </h1>
                        <div class="card-body">
                            <form action="adminLogin.php" method="POST">
                                <div class="mb-3">
                                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                                </div>
                                <div class="mb-3">
                                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                                </div>
                                <div class="mb-3 text-center">
                                    <button type="submit" name="submit" class="btn btn-primary me-2">Login</button>
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
    </body>

</html>