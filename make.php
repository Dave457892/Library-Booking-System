<?php
session_start(); 


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New User</title>
    <link rel="stylesheet" href="make.css">
</head>
<body>
    <div class="login-container">
        <h2>Add New User</h2>
        <form action="make_process.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="profile_image">Profile Image:</label>
                <input type="file" name="profile_image" id="profile_image">
            </div>
            <?php if ($_SESSION['role'] === 'admin'): ?>
            <div class="form-group">
                <label for="role">Role:</label>
                <select name="role" id="role" required>
                    <option value="user" selected>User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <?php endif; ?>
            <div class="form-group">
                <input type="submit" value="Add User">
            </div>
        </form>
        <br>
        <a href="index.php">View All Users</a>
    </div>
</body>
</html>

