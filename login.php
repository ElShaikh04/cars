<?php
session_start();
include 'db_connect.php'; 

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM cars_admins WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['admin'] = $row;

            // Redirect based on role
            if ($row['role'] == 1) {
                header('Location: index.php'); // Redirect to Super Admin dashboard
                exit;
            } elseif ($row['role'] == 2) {
                header('Location: dashboard_role_2.php'); // Redirect to Admin dashboard (view only)
                exit;
            } elseif ($row['role'] == 3) {
                header('Location: https://bootstrapmade.com/demo/QuickStart/'); // Redirect to BootstrapMade demo
                exit;
            }
        } else {
            // Incorrect password
            echo "<div class='alert alert-danger'>Incorrect email or password.</div>";
        }
    } else {
        // User not found
        echo "<div class='alert alert-danger'>User not found.</div>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Admin Login</h1>
        <form method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary btn-block mt-4">Login</button>
            <p>Make an account? <a href="register.php" class="btn btn-secondary btn-sm">Register Here</a></p>
            
        </form>
        
    </div>
</body>
</html>