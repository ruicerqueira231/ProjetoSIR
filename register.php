<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registration Page</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Custom styles -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <div class="container px-4">
        <a class="navbar-brand" href="index.html">EventHub</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="d-flex justify-content-center align-items-center vh-100">
        <img src="assets/logo240.png" alt="Your Logo" class="logo mb-4 h2">
        <div class="card">
            <div class="card-body">
            <form id="registrationForm" action="includes/register.inc.php" method="post">
                    <h2 class="text-center mb-4">Register</h2>
                    <!-- Name input -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control"  placeholder="Enter your name" required>
                        <?php if(isset($_GET["error"]) && $_GET["error"] == "emptyinput"){ echo '<small class="text-danger">Please enter your name.</small>'; } ?>
                    </div>

                    <!-- Phone input -->
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" class="form-control"  placeholder="Enter your phone number" required>
                        <?php if(isset($_GET["error"]) && $_GET["error"] == "invalidPhone"){ echo '<small class="text-danger">Invalid phone number format.</small>'; } ?>
                    </div>

                    <!-- Username input -->
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control"  placeholder="Enter your username" required>
                        <?php if(isset($_GET["error"]) && $_GET["error"] == "invalidUsername"){ echo '<small class="text-danger">Invalid username format: Only letters and numbers allowed.</small>'; } ?>
                    </div>

                    <!-- Email input -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control"  placeholder="Enter your email" required>
                        <?php if(isset($_GET["error"]) && $_GET["error"] == "invalidEmail"){ echo '<small class="text-danger">Invalid email format.</small>'; } ?>
                    </div>

                    <!-- Password input -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                    </div>

                    <!-- Confirm Password input -->
                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password</label>
                        <input type="password" name="passwordRepeat" class="form-control" placeholder="Confirm your password" required>
                        <?php if(isset($_GET["error"]) && $_GET["error"] == "repeatedPass"){ echo '<small class="text-danger">The passwords do not match.</small>'; } ?>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" name="submit" class="btn btn-primary btn-block">Register</button>
                </form>
            </div>
        </div>
    </div>
    <?php
             if($_GET["error"] == "stmterror"){
                echo '<small class="text-danger"> Something Went Wrong! Please try again';
            }
    ?>
</div>

<!-- Bootstrap JS and dependencies (jQuery, Popper.js) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!-- Custom JavaScript -->
<script src="scripts.js"></script>

</body>
</html>
