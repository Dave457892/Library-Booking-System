<?php
session_start();


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Book</title>
    <link rel="stylesheet" href="make.css"> 
</head>
<body>
    <div class="login-container">
        <h2>Add New Book</h2>
        <form action="add_book_process.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Book Title:</label>
                <input type="text" name="title" id="title" required pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed">
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" id="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="genre">Genre:</label>
                <input type="text" name="genre" id="genre" required pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed">
            </div>
            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" name="author" id="author" required pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed">
            </div>
            <div class="form-group">
                <label for="book_image">Book Image:</label>
                <input type="file" name="book_image" id="book_image" accept="image/*" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Add Book" onclick="return confirm('Add new book?')">
            </div>
        </form>
        <br>
        <a href="manage_book.php">View All Books</a> 
    </div>
</body>
</html>





