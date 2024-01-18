<?php
require_once 'db/db.php'; // Ensure this points to the correct path
require 'vendor/autoload.php';
use \Mailjet\Resources;

// Create database connection
$conn = mysqli_connect_mysql();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit();
    }

    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT id_user, username FROM tb_user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $userId = $user['id_user'];
        $username = $user['username'];

        // Generate a unique token for password reset
        $token = bin2hex(random_bytes(32));

        // Store the token in the database
        $insertToken = $conn->prepare("INSERT INTO password_reset (user_id, token) VALUES (?, ?)");
        $insertToken->bind_param("is", $userId, $token);
        $insertToken->execute();
        $insertToken->close();

        // Construct the password reset link (adjust the URL as needed)
        $resetLink = "http://localhost/SIR/reset_password.php?token=" . $token; // Make sure this URL is correct

        // Setup Mailjet client
        $apiKey = '03255e432e4dc068752a70a036176eb5';
        $apiSecret = 'b16e9ddd98e1224d56d77db73155753d';
        $mj = new \Mailjet\Client($apiKey, $apiSecret, true, ['version' => 'v3.1']);

        // Prepare the email content
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "sendersir2910@outlook.com",
                        'Name' => "EventHub"
                    ],
                    'To' => [
                        [
                            'Email' => $email,
                            'Name' => $username
                        ]
                    ],
                    'Subject' => "Password Reset Link",
                    'TextPart' => "Here is your password reset link: " . $resetLink,
                    'HTMLPart' => "<h3>Password Reset</h3><p>Click <a href='" . $resetLink . "'>here</a> to reset your password.</p>"
                ]
            ]
        ];

        // Send the email
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        if ($response->success()) {
            header("location: Error/emailSentSuccessfully.php");
        } else {
            echo "Failed to send email. Error: " . $response->getStatus();
        }
    } else {
        header("location: Error/emailNotFound.php");
    }

    $stmt->close();
}

$conn->close();
?>



<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 400px;
            padding-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-3">Reset Your Password</h2>
        <p>Please enter your email address to receive a password reset link.</p>
        <form action="forgotpasswordmail.php" method="post" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
                <div class="invalid-feedback">
                    Please enter a valid email address.
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Reset Password</button>
        </form>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
</body>
</html>
