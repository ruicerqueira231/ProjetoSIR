<?php
require_once 'db/db.php';
// Create database connection
$conn = mysqli_connect_mysql();

$tokenValid = false;
$message = '';

// Check if the token is set in the URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Database query to check if the token is valid
    $stmt = $conn->prepare("SELECT user_id FROM password_reset WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $tokenValid = true;
    } else {
        $message = 'Invalid or expired token';
    }

    $stmt->close();
}

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_password']) && $tokenValid) {
    $newPassword = $_POST['new_password'];
    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update the user's password in the database
    $stmt = $conn->prepare("UPDATE tb_user SET password = ? WHERE id_user = (SELECT user_id FROM password_reset WHERE token = ?)");
    $stmt->bind_param("ss", $hashedPassword, $token);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $message = 'Your password has been updated.';
    } else {
        $message = 'An error occurred. Please try again.';
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mt-5 mb-3 text-center">Reset Your Password</h2>

                <?php if ($tokenValid): ?>
                    <form method="POST" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" name="new_password" id="new_password" required>
                            <div class="invalid-feedback">
                                Please enter a new password.
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </form>
                <?php else: ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</body>
</html>
