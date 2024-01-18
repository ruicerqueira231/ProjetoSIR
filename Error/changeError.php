<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="5;url=../dashboard.php"> <!-- Redirect to dashboard.php after 5 seconds -->
    <title>Update Failed</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mt-5">
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Update Failed!</h4>
                    <p>An error occurred while updating your information. Please try again later.</p>
                    <hr>
                    <p class="mb-0">You will be redirected back to the dashboard in 5 seconds. If you are not redirected, <a href="../dashboard.php" class="alert-link">click here</a> to return to the dashboard.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
