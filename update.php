<?php
session_start();
include 'db.php';


if ($_SESSION['role'] === 'admin') {
   
} elseif ($_SESSION['user_id'] === $_GET['id']) {
  
} else {
   
    header("Location: dashboard.php");
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="update.css"> 
</head>
<body>
    <div class="wrapper">
       
        <div class="sidebar">
            <h2>USERS</h2>
            <a href="make.php" class="btn btn-primary mb-3">Add New User</a>
           
        </div>

        
        <div class="main-content">
            <div class="header">
                <h2>Edit</h2>
            </div>

           
            <div class="content">
                <form action="update_process.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                    
                    <label for="username">Username:</label>
                    <input type="text" name="username" value="<?php echo $user['username']; ?>" required><br><br>
                    
                    <label for="email">Email:</label>
                    <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br><br>
                    
                    <label for="password">Password:</label>
                    <input type="password" name="password" placeholder="Enter new password if changing"><br><br>
                    
                    <label for="profile_image">Profile Image:</label>
                    <div class="image-container">
                        <input type="file" name="profile_image"><br><br>
                        <img src="uploads/<?php echo $user['profile_image']; ?>" width="100" class="profile-img"><br><br>
                    </div>
                    
                    <div class="button-container">
                        <input type="submit" value="Update User" class="btn btn-success" onclick="return confirm('Confirm Changes?')">
                        <a href="home.php" class="btn btn-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>


