<?php
require_once 'db/db.php';
$conn = mysqli_connect_mysql(); 
$conn->query("UPDATE statistics SET stat_value = stat_value + 1 WHERE stat_name = 'landing_page_visits'");
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Landing Page</title>
        <link rel="icon" type="image/x-icon" href="assets/manager.png" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body id="page-top">

        <!-- Hero Image -->
        <div class="image-container">
            <img class="hero-image" src="assets/hero-imagetest.jpg" alt="My image">
        </div>

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container px-4">
                <a href="#page-top">
                    <img id="logo" src="assets/image_logo-color.png" class="img-fluide" alt="Responsive image">
                </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#photo-library">Events</a></li>
                <li class="nav-item"><a class="nav-link" href="#developers">Developers</a></li>
                <li class="nav-item"><a class="nav-link" href="#reviews">Reviews</a></li>
                <li class="nav-item"><a class="nav-link nav-link-login ms-5 rounded px-5" href="login.php">Login</a></li>
            </ul>
        </div>
    </div>
  </nav>
  
        <!-- Entrance text-->
        <div class="entrance-container">
            <div class="text-white text-center">
                <div class="container px-3 mx-auto">
                    <h1 class="fw-bolder text-sm">Welcome to EventHub</h1>
                    <p class="lead text-sm">"EventHub: Crafting Moments, Managing Memories – Your Seamless Path to Unforgettable Events!"</p>
                    <a class="btn btn-lg btn-light" id="getStartedBtn" href="register.php">Get Started!</a>
                </div>
            </div>
        </div>

        <!-- About section -->
        <section id="about">
            <div class="container px-4 custom-container">
                <div class="row gx-4 mx-auto">
                    <div class="col-lg-6">
                        <h2>About EventHub</h2>
                        <p class="lead">Welcome to EventHub, the ultimate platform for discovering and attending a variety of events! EventHub is designed to connect you with a diverse range of exciting events happening around you. Whether you're looking for concerts, festivals, sports events, or more, EventHub has you covered.</p>
                        <p class="lead">Key features of EventHub:</p>
                        <ul>
                            <li>Explore a diverse range of events in your area</li>
                            <li>Effortlessly manage and schedule your attendance</li>
                            <li>Flexible options for attending events solo or with friends</li>
                            <li>Seamless photo sharing to capture and cherish memories</li>
                        </ul>
                    </div>
        
                    <div class="col-lg-6 mt-4 mt-lg-0 ml-lg-4"> <!-- Added ml-lg-4 to add margin left to the image container -->
                        <div class="img-container text-center">
                            <img id="aboutImage" src="assets/about-image.jpg" alt="About EventHub" class="img-fluid rounded shadow-lg">
                        </div>
                    </div>        
                </div>
            </div>
        </section>
              

        <!-- Photo Library section -->
        <section class="bg-light" id="photo-library">
            <div class="container px-4">
                <div class="row gx-4 justify-content-center">
                    <div class="col-lg-8">
                        <h2>Events awaiting you!</h2>
                        <p class="lead">Take a glimpse into the exciting events we've hosted in the past or are currently awaiting your participation.</p>
                        <!-- Photo Gallery Modal Trigger Button -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#photoGalleryModal">
                            View Events
                        </button>
                    </div>
                </div>
            </div>

        <!-- Photo Gallery Modal -->
            <div class="modal fade" id="photoGalleryModal" tabindex="-1" aria-labelledby="photoGalleryModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="photoGalleryModalLabel">Event Gallery</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Carousel for Photo Gallery -->
                            <div id="photoGalleryCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <!-- Add your event photos as carousel items -->
                                    <div class="carousel-item active">
                                        <img src="assets/fotos/neopop2023.png" class="d-block w-100 img-fluid" alt="Neopop 2023">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="assets/fotos/rececaoViana2023.png" class="d-block w-100 img-fluid" alt="Receção Ao Caloiro IPVC 2023">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="assets/fotos/agonia2023.png" class="d-block w-100 img-fluid" alt="Romaria Sra Agonia 2023">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="assets/fotos/rampastluzia2023.png" class="d-block w-100 img-fluid" alt="Rampa de St Luzia 2023">
                                    </div>
                                    
                                </div>
                               
                                <a class="carousel-control-prev" href="#photoGalleryCarousel" role="button" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#photoGalleryCarousel" role="button" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Project Developers section -->
        <section id="developers">
            <div class="container px-4">
                <div class="row gx-4 justify-content-center">
                    <div class="col-lg-8 text-center">
                        <h2>Project Developers</h2>
                        <p class="lead">We are the developers behind this project. We enjoyed working on it and hope you find it useful and enjoyable.</p>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="rounded-circle mx-auto mb-3" style="width: 150px; height: 150px; overflow: hidden;">
                                    <img src="assets/devs/fernando2.png" class="img-fluid" alt="Developer 1">
                                </div>
                                <p>Fernando</p>
                            </div>
                            <div class="col-md-6">
                                <div class="rounded-circle mx-auto mb-3" style="width: 150px; height: 150px; overflow: hidden;">
                                    <img src="assets/devs/rui2.jpg" class="img-fluid" alt="Developer 2">
                                </div>
                                <p>Rui Cerqueira</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Customer reviews -->
        <section id="reviews" class="bg-light">
            <div class="container mt-5">
              <div class="d-flex justify-content-center">
                <h2>Customer Reviews</h2>
              </div>
          
              <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
                <!-- Review 1 -->
                <div class="col mb-5">
                  <div class="card h-100">
                    <div class="card-body">
                      <img src="assets/boy.png" alt="Customer review" class="boy-image">
                      <img src="assets/rating.png" alt="star" class="stars">
                      <p class="card-text">"Fantastic service! Will definitely recommend to others."</p>
                      <p class="card-subtitle text-muted">- João Félix</p>
                    </div>
                  </div>
                </div>
          
                <!-- Review 2 -->
                <div class="col mb-5">
                  <div class="card h-100">
                    <div class="card-body">
                      <img src="assets/boy.png" alt="Customer review" class="boy-image">
                      <img src="assets/rating.png" alt="star" class="stars">
                      <p class="card-text">"Amazing to share events with friends! Rui and Fernando are good people."</p>
                      <p class="card-subtitle text-muted">- Cristiano Ronaldo</p>
                    </div>
                  </div>
                </div>
          
                <!-- Review 3 -->
                <div class="col mb-5">
                  <div class="card h-100">
                    <div class="card-body">
                      <img src="assets/boy.png" alt="Customer review" class="boy-image">
                      <img src="assets/rating.png" alt="star" class="stars">
                      <p class="card-text">"The website is user-friendly! Thanks to Rui and Fernando for making it easier to plan events with friends."</p>
                      <p class="card-subtitle text-muted">- Presidente Marcelo</p>
                    </div>
                  </div>
                </div>
          
                <!-- Review 4 -->
                <div class="col mb-5">
                  <div class="card h-100">
                    <div class="card-body">
                      <img src="assets/boy.png" alt="Customer review" class="boy-image">
                      <img src="assets/rating.png" alt="star" class="stars">
                      <p class="card-text">"When I enter in this website I feel in home! Thanks to the developers."</p>
                      <p class="card-subtitle text-muted">- Gandhi</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>

        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container px-4">
                <div class="row">
                    <!-- Copyright Text -->
                    <div class="col-md-6 text-center text-md-start">
                        <p class="m-0 text-white">Copyright &copy; EventHub 2024</p>
                    </div>

                    <!-- Management Login Link -->
                    <div class="col-md-6 text-center text-md-end">
                        <a href="adminLogin.php" class="text-white">Management Login</a>
                    </div>
                </div>
            </div>
        </footer>


        <!-- Bootstrap core JS-->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
