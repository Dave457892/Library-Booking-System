<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
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


$message = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['new_password']) && !empty($_POST['new_password'])) {
        $new_password = $_POST['new_password'];

       
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

       
        $update_sql = "UPDATE users SET password = '$hashed_password' WHERE id = '$user_id'";
        if (mysqli_query($conn, $update_sql)) {
            $message = "Password updated successfully.";
        } else {
            $message = "Error updating password.";
        }
    }

    
    if (isset($_POST['new_username']) && !empty($_POST['new_username'])) {
        $new_username = $_POST['new_username'];

        
        $update_sql = "UPDATE users SET username = '$new_username' WHERE id = '$user_id'";
        if (mysqli_query($conn, $update_sql)) {
            $message = "Username updated successfully.";
           
            $_SESSION['username'] = $new_username;  
        } else {
            $message = "Error updating username.";
        }
    }

    
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = $_FILES['profile_image']['type'];

        if (in_array($file_type, $allowed_types)) {
           
            $image_name = uniqid() . "_" . basename($_FILES['profile_image']['name']);
            $upload_dir = 'uploads/';
            $upload_file = $upload_dir . $image_name;

            
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $upload_file)) {
                
                $update_sql = "UPDATE users SET profile_image = '$image_name' WHERE id = '$user_id'";
                if (mysqli_query($conn, $update_sql)) {
                    $message = "Profile image updated successfully.";
                   
                    $_SESSION['profile_image'] = $image_name;
                } else {
                    $message = "Error updating profile image.";
                }
            } else {
                $message = "Failed to upload the image.";
            }
        } else {
            $message = "Invalid file type. Only JPEG, PNG, and GIF are allowed.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="user_info.css">
</head>
<body>
    <div class="wrapper">
        <div class="sidebar">
       
            <div class="profile">
                <img src="uploads/<?php echo $user['profile_image']; ?>" alt="Profile Picture" class="profile-pic">
                <div class="user-info">
                    <h3><?php echo $user['username']; ?></h3>
                    <p class="role"><?php echo ucfirst($user['role']); ?></p>
                </div>
            </div>
            <ul>
                <li><a href="dashboard.php">Back to Dashboard</a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="header">
                <h2>Edit Profile</h2>
            </div>
            <div class="content">
                <h3>My Information</h3>
                <div class="info-box">
                    <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
                    <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
                    <p><strong>Role:</strong> <?php echo ucfirst($user['role']); ?></p>
                </div>

                
                <?php if (!empty($message)) { echo "<p class='message'>$message</p>"; } ?>

               
                <h4>Change Username</h4>
                <form method="POST" action="user_profile.php">
                    <label for="new_username">New Username:</label>
                    <input type="text" id="new_username" name="new_username" value="<?php echo $user['username']; ?>" required>
                    <button type="submit" class="change-username-btn">Change Username</button>
                </form>

               
                <h4>Change Password</h4>
                <form method="POST" action="user_profile.php">
                    <label for="new_password">New Password:</label>
                    <input type="password" id="new_password" name="new_password" required>
                    <button type="submit" class="change-password-btn">Change Password</button>
                </form>

             
                <h4>Change Profile Image</h4>
                <form method="POST" enctype="multipart/form-data">
                    <label for="profile_image">Upload New Profile Image:</label>
                    <input type="file" id="profile_image" name="profile_image" accept="image/jpeg, image/png, image/gif" required>
                    <button type="submit" class="change-image-btn">Change Profile Image</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
