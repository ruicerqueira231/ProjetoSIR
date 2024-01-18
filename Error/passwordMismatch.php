<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="5;url=../changeUserInfo.php"> <!-- Redirect to changeUserInfo.php after 5 seconds -->
    <title>Password Mismatch</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mt-5">
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">Password Mismatch!</h4>
                    <p>The new password you entered doesnt match. Please try again.</p>
                    <hr>
                    <p class="mb-0">You will be redirected back to the change information page in 5 seconds. If you are not redirected, <a href="../changeUserInfo.php" class="alert-link">click here</a> to try again.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
