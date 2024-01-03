<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body class="d-flex align-items-center">

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 bg-white shadow box-area align-items-center">
            <!-- Left Column -->
            <div class="col-md-4 rounded-4 d-flex justify-content-center align-items-center flex-column left-box">
                <div class="logo image mb-3">
                    <img src="assets/image-logo-black.png" class="img-fluid" style="width: 175px">
                </div>
                <div class="text">
                    <p class="text-center text-wrap">Welcome to EventHub – your gateway to seamless event management! Our login page ensures a secure and personalized experience.</p>
                </div>
            </div>
            <!-- Right Column -->
            <div class="col-md-5 right-box">
                    <div class="row align-items-center justify-content-center">
                        <div class="header-text mb-4">
                            <p>Login to EventHub</p>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Username">
                        </div>
                        <div class="input-group mb-1">
                            <input type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Password">
                        </div>
                        <div class="input-group mb-5 d-flex justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="formCheck">
                                <label for="formCheck" class="form-check-label text-secondary"><small>Remember me?</small></label>
                            </div>
                            <div class="forgot">
                                <small><a href="#">Forgot Password?</a></small>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>