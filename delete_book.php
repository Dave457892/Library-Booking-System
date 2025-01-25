<?php
session_start();
include 'db.php';


if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    
    $check_status_sql = "SELECT status FROM books WHERE id = $id";
    $result = mysqli_query($conn, $check_status_sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $book = mysqli_fetch_assoc($result);

        
        if ($book['status'] === 'rented' || $book['status'] === 'unavailable') {
            echo "You cannot delete this book because it is currently rented or unavailable.";
            exit(); 
        }

        
        $disable_fk_sql = "SET foreign_key_checks = 0";
        mysqli_query($conn, $disable_fk_sql);

       
        $delete_sql = "DELETE FROM books WHERE id = $id";
        if (mysqli_query($conn, $delete_sql)) {
            header("Location: manage_book.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }

       
        $enable_fk_sql = "SET foreign_key_checks = 1";
        mysqli_query($conn, $enable_fk_sql);
    } else {
        echo "Book not found!";
    }

} else {
    echo "Invalid or missing ID!";
}

mysqli_close($conn);
?>



