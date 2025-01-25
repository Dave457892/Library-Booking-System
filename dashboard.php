<?php 
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'admin') {
    header("Location: index.php"); 
    exit();
}

include 'db.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['profile_image'])) {
    $_SESSION['profile_image'] = $user['profile_image'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="newestdash.css"> 
</head>
<body>
    <div class="wrapper">
        
        <div class="sidebar">
            
            <div class="profile">
                <img src="uploads/<?php echo $_SESSION['profile_image']; ?>" alt="Profile Picture" class="profile-pic">
                <div class="user-info">
                    <h3><a href="user_profile.php"><?php echo $_SESSION['username']; ?></a></h3>
                    <p class="role"><?php echo ucfirst($_SESSION['role']); ?></p>
                </div>
            </div>

            <ul>
                <li><a href="browse.php">View Books</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="history.php">History</a></li> 
                <li><a href="logout_confirm.php">Logout</a></li>
            </ul>
        </div>

        <div class="main-content">
           
            <div class="main-header">
                <h2>Welcome to Our Online Reservation!</h2>
                <div class="top-right-links">
                    <a href="about.php">About Us</a>
                    <a href="contact.php">Contact</a>
                </div>
            </div>
            <div class="content">
                <p>We are excited to offer you a convenient way to reserve your next great read. Browse our collection, choose your book, and reserve it in just a few easy steps. Whether you're looking for a thrilling novel, an inspiring non-fiction, or something in between, we’ve got you covered.

Reserve your book now and dive into a new adventure today!</p>
            </div>
        </div>
    </div>
</body>
</html>













