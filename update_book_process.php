<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id = $_POST['id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $price = is_numeric($_POST['price']) ? $_POST['price'] : 0;  
    $book_image = $_FILES['book_image']['name'];
    $target_file = "";

    
    if ($book_image) {
        $target_dir = "books/";  
        $target_file = $target_dir . basename($book_image); 
        move_uploaded_file($_FILES["book_image"]["tmp_name"], $target_file); 
    }

    
    if ($book_image) {
        $sql = "UPDATE books SET 
                    Title = '$title',
                    Description = '$description',
                    Genre = '$genre',
                    Author = '$author',
                    Price = '$price',
                    book_image = '$book_image'
                    WHERE id = $id";
    } else {
        
        $sql = "UPDATE books SET 
                    Title = '$title',
                    Description = '$description',
                    Genre = '$genre',
                    Author = '$author',
                    Price = '$price'
                    WHERE id = $id";
    }

   
    if (mysqli_query($conn, $sql)) {
        header("Location: manage_book.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>










