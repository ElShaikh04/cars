<?php
session_start();
include 'db_connect.php'; 

// Check if the user is logged in 
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$admin_role = $_SESSION['admin']['role'];

// Process form for customers (add, edit, delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_customer'])) {
        // Add new customer
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
        $status = isset($_POST['status']) ? 1 : 0;

        $sql = "INSERT INTO cars_customers (name, email, password, status) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $email, $password, $status);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Customer added successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error adding customer: " . $stmt->error . "</div>";
        }

        $stmt->close();
    } elseif (isset($_POST['edit_customer'])) {
        // Edit existing customer
        $customer_id = $_POST['customer_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $status = isset($_POST['status']) ? 1 : 0;

        $sql = "UPDATE cars_customers SET name = ?, email = ?, status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $email, $status, $customer_id);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Customer updated successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error updating customer: " . $stmt->error . "</div>";
        }

        $stmt->close();
    } elseif (isset($_POST['delete_customer'])) {
        // Delete customer
        $customer_id = $_POST['customer_id'];

        $sql = "DELETE FROM cars_customers WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $customer_id);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Customer deleted successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error deleting customer: " . $stmt->error . "</div>";
        }

        $stmt->close();
    }
}

// show all customers data
$sql = "SELECT * FROM cars_customers";
$result = $conn->query($sql);

// Check if there's a customer to edit
$edit_customer = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $sql = "SELECT * FROM cars_customers WHERE id = $edit_id";
    $edit_result = $conn->query($sql);
    $edit_customer = $edit_result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Customers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Customers</h1>

        <!-- Add New Customer Form -->
        <?php if ($admin_role == 1 || $admin_role == 2): ?>
            <h2>Add New Customer</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <input type="checkbox" class="form-check-input" id="status" name="status">
                    <label class="form-check-label" for="status">Active</label>
                </div>
                <button type="submit" name="add_customer" class="btn btn-success">Add Customer</button>
            </form>
        <?php endif; ?>

        <h2>Customer List</h2>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['status'] == 1 ? 'Active' : 'Inactive'; ?></td>
                        <td class="text-center">
                            <!-- Edit and Delete buttons only for role 1 and 2 -->
                            <?php if ($admin_role == 1 || $admin_role == 2): ?>
                                <a href="?edit_id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a>
                                <form method="POST" style="display: inline-block;">
                                    <input type="hidden" name="customer_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="delete_customer" class="btn btn-danger">Delete</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Edit Customer Form -->
        <?php if ($edit_customer): ?>
            <h2>Edit Customer</h2>
            <form method="POST">
                <input type="hidden" name="customer_id" value="<?php echo $edit_customer['id']; ?>">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $edit_customer['name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $edit_customer['email']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <input type="checkbox" class="form-check-input" id="status" name="status" <?php echo ($edit_customer['status'] == 1) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="status">Active</label>
                </div>
                <button type="submit" name="edit_customer" class="btn btn-primary">Update Customer</button>
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