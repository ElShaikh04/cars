<?php
session_start();
include 'db_connect.php'; 

// Check if the user is logged in
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

// Get the admin's role from the session
$admin_role = $_SESSION['admin']['role'];

// Process form  for admins (add, edit, delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_admin'])) {
        // Add new admin
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
        $phone = $_POST['phone'];
        $rule_id = $_POST['rule_id']; 
        $role = $_POST['role']; 

        $sql = "INSERT INTO cars_admins (name, email, password, phone, rule_id, role) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssii", $name, $email, $password, $phone, $rule_id, $role);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Admin added successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error adding admin: " . $stmt->error . "</div>";
        }

        $stmt->close();
    } elseif (isset($_POST['edit_admin'])) {
        // Edit existing admin
        $admin_id = $_POST['admin_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $rule_id = $_POST['rule_id']; 
        $role = $_POST['role']; 

        $sql = "UPDATE cars_admins SET name = ?, email = ?, phone = ?, rule_id = ?, role = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssiii", $name, $email, $phone, $rule_id, $role, $admin_id);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Admin updated successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error updating admin: " . $stmt->error . "</div>";
        }

        $stmt->close();
    } elseif (isset($_POST['delete_admin']) && $admin_role == 1) {
        // Delete admin (only for Super Admin)
        $admin_id = $_POST['admin_id'];

        $sql = "DELETE FROM cars_admins WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $admin_id);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Admin deleted successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error deleting admin: " . $stmt->error . "</div>";
        }

        $stmt->close();
    }
}

// show all admins
$sql = "SELECT * FROM cars_admins";
$result = $conn->query($sql);

// Check if there's an admin to edit
$edit_admin = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $sql = "SELECT * FROM cars_admins WHERE id = $edit_id";
    $edit_result = $conn->query($sql);
    $edit_admin = $edit_result->fetch_assoc();
}


$rules_sql = "SELECT * FROM cars_rules";
$rules_result = $conn->query($rules_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Admins</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Admins</h1>

        <!-- Add New Admin Form -->
        <?php if ($admin_role == 1 || $admin_role == 2): ?>
            <h2>Add New Admin</h2>
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
                    <label for="phone">Phone:</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
                
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="1">Super Admin</option>
                        <option value="2">Admin</option>
                        <option value="3">User</option>
                    </select>
                </div>
                <button type="submit" name="add_admin" class="btn btn-success">Add Admin</button>
            </form>
        <?php endif; ?>

        <h2>Admin List</h2>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                       
                        <td><?php 
                            if ($row['role'] == 1) {
                                echo "Super Admin";
                            } elseif ($row['role'] == 2) {
                                echo "Admin";
                            } else {
                                echo "User";
                            }
                        ?></td>
                        <td class="text-center">
                            <!-- Edit and Delete buttons only for role 1 -->
                            <?php if ($admin_role == 1 ): ?>
                                <a href="?edit_id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a>
                                <form method="POST" style="display: inline-block;">
                                    <input type="hidden" name="admin_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="delete_admin" class="btn btn-danger">Delete</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Edit Admin Form -->
        <?php if ($edit_admin): ?>
            <h2>Edit Admin</h2>
            <form method="POST">
                <input type="hidden" name="admin_id" value="<?php echo $edit_admin['id']; ?>">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $edit_admin['name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $edit_admin['email']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $edit_admin['phone']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="1" <?php if ($edit_admin['role'] == 1) echo 'selected'; ?>>Super Admin</option>
                        <option value="2" <?php if ($edit_admin['role'] == 2) echo 'selected'; ?>>Admin</option>
                        <option value="3" <?php if ($edit_admin['role'] == 3) echo 'selected'; ?>>User</option>
                    </select>
                </div>
                <button type="submit" name="edit_admin" class="btn btn-primary">Update Admin</button>
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