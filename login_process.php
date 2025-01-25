<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $sql = "SELECT * FROM users WHERE username = ? OR email = ?";

         $stmt = $conn->prepare($sql);
         $stmt->bind_param("ss", $username, $username); 
         $stmt->execute();
         $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        
        if (password_verify($password, $user['password'])) {
         
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username']; 
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

           
            if ($_SESSION['role'] === 'admin') {
                header("Location: index.php");
            } else {
                header("Location: dashboard.php");
            }
            exit();
            
        } else {
            
            $_SESSION['error_message'] = "Incorrect password!";
            header("Location: login.php");
            exit();
        }
    } else {
      
        $_SESSION['error_message'] = "No user found with that username or email!";
        header("Location: login.php");
        exit();
    }
}


