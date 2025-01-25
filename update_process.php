<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];  
    $profile_image = $_FILES['profile_image']['name'];
    $target_file = "";

    
    if ($profile_image) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file);
    }

    
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
       
        if ($profile_image) {
            $sql = "UPDATE users SET username='$username', email='$email', password='$hashed_password', profile_image='$profile_image' WHERE id=$id";
        } else {
            $sql = "UPDATE users SET username='$username', email='$email', password='$hashed_password' WHERE id=$id";
        }
    } else {
        
        if ($profile_image) {
            $sql = "UPDATE users SET username='$username', email='$email', profile_image='$profile_image' WHERE id=$id";
        } else {
            $sql = "UPDATE users SET username='$username', email='$email' WHERE id=$id";
        }
    }

   
    if (mysqli_query($conn, $sql)) {
        header("Location: home.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>


