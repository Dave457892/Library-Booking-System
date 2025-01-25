<?php
session_start();


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New User</title>
    <link rel="stylesheet" href="sign_up.css">
</head>
<body>
    <h2>Add New User</h2>
    <form action="make_process.php" method="post" enctype="multipart/form-data">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>

        <label for="profile_image">Profile Image:</label>
        <input type="file" name="profile_image"><br><br>

        
        <label for="role">Role:</label>
        <select name="role" required>
            <option value="user" selected>User</option>
            <option value="admin">Admin</option>
        </select><br><br>

        <input type="submit" value="Add User">
    </form>

    <br>
    <a href="index.php">View All Users</a>
</body>
</html>
