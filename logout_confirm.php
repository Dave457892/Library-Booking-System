<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}


if (isset($_POST['logout_confirm']) && $_POST['logout_confirm'] === 'yes') {
   
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
} elseif (isset($_POST['logout_confirm']) && $_POST['logout_confirm'] === 'no') {
    
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirm Logout</title>
    <link rel="stylesheet" href="logout_confirm.css">
</head>
<body>

    <div class="logout-popup">
        <h2>Are you sure you want to log out?</h2>
        <form method="POST">
            <div class="btn-container">
                <button type="submit" name="logout_confirm" value="yes" class="btn btn-danger">Yes, Log Out</button>
                <a href="index.php" class="btn btn-secondary">No, Cancel</a>
            </div>
        </form>
    </div>

</body>
</html>

