<?php
session_start();
include 'db.php';  


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php");  
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; 
    $profile_image = $_FILES['profile_image']['name'];

    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
    move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file);

    
    $sql = "INSERT INTO users (username, email, password, profile_image, role) 
            VALUES ('$username', '$email', '$hashed_password', '$profile_image', '$role')";

    if (mysqli_query($conn, $sql)) {
        header("Location: home.php"); 
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);  
    }
}
?>




