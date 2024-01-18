<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registration Page</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        html, body {
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
            margin-top: 20px;
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
                <div class="card">
                <a href="index.php" class="d-block text-center">
                    <img src="assets/image-logo-black.png" alt="Your Logo" class="card-img-top" style="width: 30%; margin-top: 20px;">
                </a>
                    <div class="card-body">
                        <h2 class="text-center mb-4">Register</h2>
                        <form id="registrationForm" action="includes/register.inc.php" method="post">
                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" class="form-control" placeholder="Enter your phone number" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Enter your username" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="confirmPassword">Confirm Password</label>
                                <input type="password" name="passwordRepeat" class="form-control" placeholder="Confirm your password" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="securityQuestion">Security Question (Your favorite number)</label>
                                <input type="text" name="securityQuestion" class="form-control" placeholder="Your favorite number" required>
                            </div>

                            <div class="text-center">
                                <button type="submit" name="submit" class="btn btn-primary">Register</button>
                            </div>
                        </form>
                        <?php
                            if(isset($_GET["error"])) {
                                // Display error messages here
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
