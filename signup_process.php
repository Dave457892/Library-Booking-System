<?php
session_start();
include 'db.php';  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $profile_image = $_FILES['profile_image']['name'];
    $profile_image_tmp = $_FILES['profile_image']['tmp_name'];

    
    $role = 'user';
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        
        $role = $_POST['role'];
    }

    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    
    if ($profile_image) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($profile_image);
        move_uploaded_file($profile_image_tmp, $target_file);
    }

    
    $sql = "INSERT INTO users (username, email, password, profile_image, role) 
            VALUES ('$username', '$email', '$hashed_password', '$profile_image', '$role')";

    if (mysqli_query($conn, $sql)) {
       
        header("Location: login.php");
        exit();
    } else {
       
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);  
?>
