<?php
session_start();
include 'db_connect.php'; 

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$admin_role = $_SESSION['admin']['role'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_message']) && ($admin_role == 1 )) {
        $message_id = $_POST['message_id'];

        $sql = "DELETE FROM cars_messages WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $message_id);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Message deleted successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error deleting message: " . $stmt->error . "</div>";
        }

        $stmt->close();
    }
}

// show all messages 
$sql = "SELECT * FROM cars_messages";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Messages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Messages</h1>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Buyer ID</th>
                    <th>Seller ID</th>
                    <th>Message</th>
                    <th>Created At</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['buyer_id']; ?></td>
                        <td><?php echo $row['seller_id']; ?></td>
                        <td><?php echo $row['message']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td class="text-center">
                            <?php if ($admin_role == 1 || $admin_role == 2): ?>
                                <form method="POST" style="display: inline-block;">
                                    <input type="hidden" name="message_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="delete_message" class="btn btn-danger">Delete</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div class="row mt-4">
        <div class="col-12 text-center">
            <a href="index.php" class="btn btn-danger btn-lg">Back</a>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>