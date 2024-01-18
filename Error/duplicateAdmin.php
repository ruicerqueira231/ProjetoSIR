<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="5;url=../admin.php" />
    <title>Duplicate Admin Entry</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mt-5">
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">Duplicate Admin Entry!</h4>
                    <p>An admin with this username already exists. Please try again with a different username.</p>
                    <hr>
                    <p class="mb-0">You will be redirected back to the admin page in 5 seconds. If not, click <a href="../admin.php" class="alert-link">here</a>.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
