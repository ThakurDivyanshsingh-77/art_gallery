<?php
session_start();
include("../includes/db.php");

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['admin'] = $username;
        header("Location: dashboard.php");
    } else {
        $error = "Invalid Username or Password";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="form-container">
    <h3 class="form-title">Admin Login</h3>
    <?php if (!empty($error)) echo "<div class='alert alert-error'>$error</div>"; ?>
    <form method="POST">
        <div class="form-group">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
    </form>
</div>
</body>
</html>
