<?php
session_start();
include 'db_connect.php'; 

// Check if the user is logged in 
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$admin_role = $_SESSION['admin']['role'];

// Process form for (add, edit, delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_brand'])) {
        // Add new brand
        $name = $_POST['name'];
        $country = $_POST['country'];

        $sql = "INSERT INTO cars_brands (name, country) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $name, $country);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Brand added successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error adding brand: " . $stmt->error . "</div>";
        }

        $stmt->close();
    } elseif (isset($_POST['edit_brand'])) {
        // Edit existing brand
        $brand_id = $_POST['brand_id'];
        $name = $_POST['name'];
        $country = $_POST['country'];

        $sql = "UPDATE cars_brands SET name = ?, country = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $name, $country, $brand_id);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Brand updated successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error updating brand: " . $stmt->error . "</div>";
        }

        $stmt->close();
    } elseif (isset($_POST['delete_brand'])) {
        // Delete brand
        $brand_id = $_POST['brand_id'];

        $sql = "DELETE FROM cars_brands WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $brand_id);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Brand deleted successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error deleting brand: " . $stmt->error . "</div>";
        }

        $stmt->close();
    }
}

// show all brands
$sql = "SELECT * FROM cars_brands";
$result = $conn->query($sql);

// Check if there's a brand to edit
$edit_brand = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $sql = "SELECT * FROM cars_brands WHERE id = $edit_id";
    $edit_result = $conn->query($sql);
    $edit_brand = $edit_result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Brands</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Brands</h1>

        <!-- Add New Brand Form -->
        <?php if ($admin_role == 1 || $admin_role == 2): ?>
            <h2>Add New Brand</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="country">Country:</label>
                    <input type="text" class="form-control" id="country" name="country" required>
                </div>
                <button type="submit" name="add_brand" class="btn btn-success">Add Brand</button>
            </form>
        <?php endif; ?>

        <h2>Brand List</h2>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Country</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['country']; ?></td>
                        <td class="text-center">
                            <!-- Edit and Delete buttons only for role 1 -->
                            <?php if ($admin_role == 1 || $admin_role == 2): ?>
                                <a href="?edit_id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a>
                                <form method="POST" style="display: inline-block;">
                                    <input type="hidden" name="brand_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="delete_brand" class="btn btn-danger">Delete</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Edit Brand Form -->
        <?php if ($edit_brand): ?>
            <h2>Edit Brand</h2>
            <form method="POST">
                <input type="hidden" name="brand_id" value="<?php echo $edit_brand['id']; ?>">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $edit_brand['name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="country">Country:</label>
                    <input type="text" class="form-control" id="country" name="country" value="<?php echo $edit_brand['country']; ?>" required>
                </div>
                <button type="submit" name="edit_brand" class="btn btn-primary">Update Brand</button>
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