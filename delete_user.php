<?php
session_start();
include 'db.php'; 


if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php"); 
    exit();
}


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id']; 

    
    mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");

    
    mysqli_begin_transaction($conn);

    try {
       
        $delete_cart_sql = "DELETE FROM carts WHERE user_id = $id";
        mysqli_query($conn, $delete_cart_sql);  
       
        $delete_user_sql = "DELETE FROM users WHERE id = $id";
        mysqli_query($conn, $delete_user_sql);  

       
        mysqli_commit($conn);

        
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");

       
        header("Location: home.php");
        exit();
    } catch (Exception $e) {
       
        mysqli_rollBack($conn);
        echo "Error: " . $e->getMessage();

        
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");
    }
} else {
    
    echo "Invalid or missing ID!";
}

mysqli_close($conn); 


?>



