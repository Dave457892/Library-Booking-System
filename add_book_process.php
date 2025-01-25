<?php
session_start();
include 'db.php';  


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php"); 
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    
    
    if (!preg_match("/^[A-Za-z\s]+$/", $title)) {
        echo "Title can only contain letters and spaces.<br>";
        exit();
    }

    if (!preg_match("/^[A-Za-z\s]+$/", $genre)) {
        echo "Genre can only contain letters and spaces.<br>";
        exit();
    }

    if (!preg_match("/^[A-Za-z\s]+$/", $author)) {
        echo "Author can only contain letters and spaces.<br>";
        exit();
    }

    
    if (isset($_FILES['book_image']) && $_FILES['book_image']['error'] == 0) {
        $image = $_FILES['book_image'];
        $image_name = uniqid() . "_" . basename($image['name']);
        $image_tmp = $image['tmp_name'];

        
        $image_dir = 'books/';

        
        if (!is_dir($image_dir)) {
            mkdir($image_dir, 0777, true); 
        }

       
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($image['type'], $allowed_types)) {
            $image_path = $image_dir . $image_name;

            
            if (move_uploaded_file($image_tmp, $image_path)) {
               
                $sql = "INSERT INTO books (title, description, genre, author, book_image) 
                        VALUES ('$title', '$description', '$genre', '$author', '$image_name')";
                if (mysqli_query($conn, $sql)) {
                    header("Location: manage_book.php");
                    exit();
                } else {
                    echo "Error: " . mysqli_error($conn); 
                }
            } else {
                echo "Failed to upload image.";
            }
        } else {
            echo "Invalid file type. Only JPEG, PNG, and GIF are allowed.";
        }
    } else {
        echo "Error: No image uploaded.";
    }
}
?>



