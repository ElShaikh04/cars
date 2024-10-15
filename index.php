<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Management</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Settings</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Profile</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Welcome to Your Dashboard</h1>
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manage Customers</h5>
                        <p class="card-text">Manage customers and update their data</p>
                        <a href="customers.php" class="btn btn-primary">Manage</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manage Cars</h5>
                        <p class="card-text">Manage the company's cars and update their data</p>
                        <a href="cars.php" class="btn btn-primary">Manage</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manage Brands</h5>
                        <p class="card-text">Manage company's brands and thier location</p>
                        <a href="brands.php" class="btn btn-primary">Manage </a>
                    </div>
                </div>
            </div><div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manage Admins</h5>
                        <p class="card-text">Manage admins & users data and update them</p>
                        <a href="admins.php" class="btn btn-primary">Manage </a>
                    </div>
                </div>
            </div><div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">View Messages</h5>
                        <p class="card-text"> View feedbacks and reports</p>
                        <a href="messages.php" class="btn btn-primary">Manage </a>
                    </div>
                </div>
            </div><div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manage Customers</h5>
                        <p class="card-text">View customers data and update their data</p>
                        <a href="customers.php" class="btn btn-primary">Manage </a>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="mt-5 mb-4">Recent Activity</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Action</th>
                        <th>Description</th>
                        <th>User</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2023-11-16</td>
                        <td>Order Placed</td>
                        <td>Order #12345 for product C180</td>
                        <td>John Doe</td>
                    </tr>
                    <tr>
                        <td>2023-11-15</td>
                        <td>Product Added</td>
                        <td>New product Sl63 added to inventory</td>
                        <td>Jane Smith</td>
                    </tr>
                    <tr>
                        <td>2023-11-14</td>
                        <td>Customer Registered</td>
                        <td>New customer David Wilson registered</td>
                        <td>System</td>
                    </tr>
                </tbody>
            </table>
             <!-- Logout Button -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="logout.php" class="btn btn-danger btn-lg">Logout</a>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>