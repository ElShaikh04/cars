<?php
session_start();
include 'db_connect.php';

// Check if the user is logged in 
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$admin_role = $_SESSION['admin']['role'];

// Process form for car management (add, edit, delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_car'])) {
        // Add new car
        $title = $_POST['title'];
        $brand_id = $_POST['brand_id'];
        $model_year = $_POST['model_year'];
        $KM = $_POST['KM'];
        $color = $_POST['color'];
        $price = $_POST['price'];
        $status = isset($_POST['status']) ? 1 : 0;
        $customer_id = $_POST['customer_id'];

        $sql = "INSERT INTO cars (title, brand_id, model_year, KM, color, price, status, customer_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siiiisii", $title, $brand_id, $model_year, $KM, $color, $price, $status, $customer_id);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Car added successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error adding car: " . $stmt->error . "</div>";
        }

        $stmt->close();
    } elseif (isset($_POST['edit_car'])) {
        // Edit existing car
        $car_id = $_POST['car_id'];
        $title = $_POST['title'];
        $brand_id = $_POST['brand_id'];
        $model_year = $_POST['model_year'];
        $KM = $_POST['KM'];
        $color = $_POST['color'];
        $price = $_POST['price'];
        $status = isset($_POST['status']) ? 1 : 0;
        $customer_id = $_POST['customer_id'];

        $sql = "UPDATE cars SET title = ?, brand_id = ?, model_year = ?, KM = ?, color = ?, price = ?, status = ?, customer_id = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siiiisiii", $title, $brand_id, $model_year, $KM, $color, $price, $status, $customer_id, $car_id);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Car updated successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error updating car: " . $stmt->error . "</div>";
        }

        $stmt->close();
    } elseif (isset($_POST['delete_car'])) {
        // Delete car
        $car_id = $_POST['car_id'];

        $sql = "DELETE FROM cars WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $car_id);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Car deleted successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error deleting car: " . $stmt->error . "</div>";
        }

        $stmt->close();
    }
}

// Fetch cars data
$sql = "SELECT c.*, b.name AS brand_name, cu.name AS customer_name FROM cars c JOIN cars_brands b ON c.brand_id = b.id JOIN cars_customers cu ON c.customer_id = cu.id";
$result = $conn->query($sql);

// Check if there's a car to edit
$edit_car = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $sql = "SELECT * FROM cars WHERE id = $edit_id";
    $edit_result = $conn->query($sql);
    $edit_car = $edit_result->fetch_assoc();
}

// Fetch brands and customers for dropdown
$brands_sql = "SELECT * FROM cars_brands";
$brands_result = $conn->query($brands_sql);

$customers_sql = "SELECT * FROM cars_customers";
$customers_result = $conn->query($customers_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Cars</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Cars</h1>

        <!-- Add New Car Form -->
        <?php if ($admin_role == 1 || $admin_role == 2): ?>
            <h2>Add New Car</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="brand_id">Brand:</label>
                    <select class="form-control" id="brand_id" name="brand_id" required>
                        <?php while ($brand = $brands_result->fetch_assoc()): ?>
                            <option value="<?php echo $brand['id']; ?>"><?php echo $brand['name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="model_year">Model Year:</label>
                    <input type="number" class="form-control" id="model_year" name="model_year" required>
                </div>
                <div class="form-group">
                    <label for="KM">KM:</label>
                    <input type="number" class="form-control" id="KM" name="KM" required>
                </div>
                <div class="form-group">
                    <label for="color">Color:</label>
                    <input type="text" class="form-control" id="color" name="color" required>
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" class="form-control" id="price" name="price" required>
                </div>
                <div class="form-group">
                    <label for="customer_id">Customer:</label>
                    <select class="form-control" id="customer_id" name="customer_id" required>
                        <?php while ($customer = $customers_result->fetch_assoc()): ?>
                            <option value="<?php echo $customer['id']; ?>"><?php echo $customer['name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <input type="checkbox" class="form-check-input" id="status" name="status">
                    <label class="form-check-label" for="status">Active</label>
                </div>
                <button type="submit" name="add_car" class="btn btn-success">Add Car</button>
            </form>
        <?php endif; ?>

        <h2>Car List</h2>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Brand</th>
                    <th>Model Year</th>
                    <th>KM</th>
                    <th>Color</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Customer</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['brand_name']; ?></td>
                        <td><?php echo $row['model_year']; ?></td>
                        <td><?php echo $row['KM']; ?></td>
                        <td><?php echo $row['color']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><?php echo $row['status'] == 1 ? 'Active' : 'Inactive'; ?></td>
                        <td><?php echo $row['customer_name']; ?></td>
                        <td class="text-center">
                            <!-- Edit and Delete buttons only for role 1 and 2 -->
                            <?php if ($admin_role == 1 || $admin_role == 2): ?>
                                <a href="?edit_id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a>
                                <form method="POST" style="display: inline-block;">
                                    <input type="hidden" name="car_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="delete_car" class="btn btn-danger">Delete</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Edit Car Form -->
        <?php if ($edit_car): ?>
            <h2>Edit Car</h2>
            <form method="POST">
                <input type="hidden" name="car_id" value="<?php echo $edit_car['id']; ?>">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo $edit_car['title']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="brand_id">Brand:</label>
                    <select class="form-control" id="brand_id" name="brand_id" required>
                        <?php while ($brand = $brands_result->fetch_assoc()): ?>
                            <option value="<?php echo $brand['id']; ?>" <?php if ($brand['id'] == $edit_car['brand_id']) echo 'selected'; ?>><?php echo $brand['name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="model_year">Model Year:</label>
                    <input type="number" class="form-control" id="model_year" name="model_year" value="<?php echo $edit_car['model_year']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="KM">KM:</label>
                    <input type="number" class="form-control" id="KM" name="KM" value="<?php echo $edit_car['KM']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="color">Color:</label>
                    <input type="text" class="form-control" id="color" name="color" value="<?php echo $edit_car['color']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" class="form-control" id="price" name="price" value="<?php echo $edit_car['price']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="customer_id">Customer:</label>
                    <select class="form-control" id="customer_id" name="customer_id" required>
                        <?php while ($customer = $customers_result->fetch_assoc()): ?>
                            <option value="<?php echo $customer['id']; ?>" <?php if ($customer['id'] == $edit_car['customer_id']) echo 'selected'; ?>><?php echo $customer['name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <input type="checkbox" class="form-check-input" id="status" name="status" <?php echo ($edit_car['status'] == 1) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="status">Active</label>
                </div>
                <button type="submit" name="edit_car" class="btn btn-primary">Update Car</button>
            </form>
        <?php endif; ?>
        <div class="row mt-4">
        <div class="col-12 text-center">
            <a href="index.php" class="btn btn-danger btn-lg">Back</a>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>