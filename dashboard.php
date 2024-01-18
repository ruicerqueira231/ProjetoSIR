<?php
session_start();
// Redirect to login if not logged in
if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

require_once 'db/db.php'; 
require_once 'includes/event.inc.php';

// Handle logout
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect_mysql();

if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$user_id = $_SESSION['userId'];

$events = getEventsByUserId($conn, $user_id);

if (isset($conn)) {
    $conn->close();
}

require_once 'db/db.php';
require_once 'includes/event.inc.php';

$conn = mysqli_connect_mysql();
$categories = getCategories($conn);

if (!isset($_SESSION['userId'])) {
    header("location: login.php");
    exit();
}


//Criar Evento
if (isset($_POST['submit'])) {
    $name = $_POST['nome'];
    $localizacao = $_POST['localizacao'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $id_category = $_POST['category'];
    $user_id = $_SESSION['userId'];

    // Handle the file upload
    $imageFileName = '';
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $imageFileName = basename($_FILES['imagem']['name']);
        $tempName = $_FILES['imagem']['tmp_name'];
        $uploadDir = 'assets/'; 

        // Move the file to your upload directory
        if (!move_uploaded_file($tempName, $uploadDir . $imageFileName)) {
            echo "Failed to upload file.";
            exit;
        }
    }

    // Create the event with the image file name
    $event_id = createEvent($conn, $name, $localizacao, $data, $hora, $id_category, $user_id, $imageFileName);

    if ($event_id === false) {
        echo "Failed to create event.";
        exit;
    }

    $query = "INSERT INTO tb_participacao (id_user, id_event) VALUES (?, ?)";
    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, "ii", $user_id, $event_id);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Error: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
        <link href="css/dashboard.css" rel="stylesheet">
        <!-- Font Awesome for icons -->
    </head>
    <body>

        <?php require 'navbar.php';?>

            <!-- Page Content -->
            <section id="events-section">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eventModal" id="addEventButton">
                    Add Event
                </button>
                <h2>Your Events</h2>
                <div class="row" id="events-container">
                    <?php if (!empty($events)): ?>
                        <?php foreach ($events as $event): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <a href="eventinfo.php?id=<?php echo htmlspecialchars($event['id_event']); ?>" class="card-body text-decoration-none text-dark">
                                        <!-- Image -->
                                        <?php if (!empty($event['image_path'])): ?>
                                            <img src="assets/<?php echo htmlspecialchars($event['image_path']); ?>" alt="Event Image" style="max-width: 100%; height: auto;">
                                        <?php else: ?>
                                            <img src="assets/about-image.jpg" alt="Default Image" style="max-width: 100%; height: auto;">
                                        <?php endif; ?>
                                        <h5 class="card-title"><?php echo htmlspecialchars($event['name']); ?></h5>
                                        <p class="card-text">Location: <?php echo htmlspecialchars($event['localizacao']); ?></p>
                                        <p class="card-text">Date: <?php echo htmlspecialchars($event['date_event']); ?></p>
                                        <p class="card-text">Time: <?php echo htmlspecialchars($event['hora']); ?></p>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No events found.</p>
                    <?php endif; ?>
                </div>
            </section>



    <!-- Add Event Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Criar Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="dashboard.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome do Evento:</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>

                        <div class="mb-3">
                            <label for="localizacao" class="form-label">Localização:</label>
                            <input type="text" class="form-control" id="localizacao" name="localizacao" required>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="data" class="form-label">Data:</label>
                                <input type="date" class="form-control" id="data" name="data" required>
                            </div>
                            <div class="col-md-6">
                                <label for="hora" class="form-label">Hora:</label>
                                <input type="time" class="form-control" id="hora" name="hora" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="imagem" class="form-label">Imagem do Evento:</label>
                            <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*" required>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Categoria:</label>
                            <select class="form-select" name="category" id="category">
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id_category']; ?>"><?= htmlspecialchars($category['category']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" name="submit">Criar Evento</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
        <script src="js/dashboard.js"></script>
    </body>
</html>
