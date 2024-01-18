<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="5;url=../adminLogin.php"> <!-- Redirect to adminLogin.php after 5 seconds -->
    <title>No Admin Found</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mt-5">
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">No Admin Found!</h4>
                    <p>The username you entered does not exist. Please try again.</p>
                    <hr>
                    <p class="mb-0">You will be redirected back to the admin login page in 5 seconds. If you are not redirected, <a href="../adminLogin.php" class="alert-link">click here</a> to return to the admin login page.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
