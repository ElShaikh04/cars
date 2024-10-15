<?php
session_start();
include 'db_connect.php';

// Check if the user is logged in and is an Admin (role 2)
if (!isset($_SESSION['admin']) || $_SESSION['admin']['role'] != 2) {
    header('Location: login.php');
    exit;
}
// Fake data to show ... Replaced with ur real data
$total_cars = 10; 
$total_customers = 25; 
$recent_cars = [
    ['title' => 'Car 1', 'brand' => 'Brand A', 'model_year' => 2023],
    ['title' => 'Car 2', 'brand' => 'Brand B', 'model_year' => 2022],
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 text-center">
                <h1>Welcome, <?php echo $_SESSION['admin']['name']; ?>!</h1>
                <p>Admin Dashboard</p>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Cars</h5>
                        <p class="card-text display-4"><?php echo $total_cars; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Customers</h5>
                        <p class="card-text display-4"><?php echo $total_customers; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Recent Cars</h5>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($recent_cars as $car): ?>
                                <li class="list-group-item">
                                    <?php echo $car['title']; ?> (<?php echo $car['brand']; ?>, <?php echo $car['model_year']; ?>)
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
    <div class="col-12 text-center">
         <!-- logout button -->
        <?php 
        session_unset(); 
        session_destroy(); 
        ?>
        <a href="login.php" class="btn btn-danger btn-lg">Logout</a>
    </div>
</div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>