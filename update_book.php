<?php
session_start();
include 'db.php';


if ($_SESSION['role'] === 'admin') {
   
} else {
   
    header("Location: dashboard.php");
    exit();
}

$id = $_GET['id'];  
$sql = "SELECT * FROM books WHERE id = $id";
$result = mysqli_query($conn, $sql);
$book = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Book</title>
    <link rel="stylesheet" href="update.css">
</head>
<body>
    <div class="wrapper">
        <div class="sidebar">
            <h2>BOOKS</h2>
            <a href="make.php" class="btn btn-primary mb-3">Add New Book</a>
            <a href="manage_book.php" class="btn btn-info mb-3">Manage Books</a>
        </div>

        <div class="main-content">
            <div class="header">
                <h2>Edit Book</h2>
            </div>

            <div class="content">
                
                <form action="update_book_process.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $book['ID']; ?>"> 
                    <input type="hidden" name="current_image" value="<?php echo $book['book_image']; ?>"> 

                    <label for="title">Title:</label>
                    <input type="text" name="title" value="<?php echo $book['Title']; ?>" required pattern="[A-Za-z\s]+" title="Only letters are allowed"><br><br>

                    <label for="description">Description:</label>
                    <textarea name="description" required pattern="[A-Za-z\s]+" title="Only letters are allowed"><?php echo $book['Description']; ?></textarea><br><br>

                    <label for="genre">Genre:</label>
                    <input type="text" name="genre" value="<?php echo $book['Genre']; ?>" required pattern="[A-Za-z\s]+" title="Only letters are allowed"><br><br>

                    <label for="author">Author:</label>
                    <input type="text" name="author" value="<?php echo $book['Author']; ?>" required pattern="[A-Za-z\s]+" title="Only letters are allowed"><br><br>

                    <label for="price">Price:</label>
                    <input type="text" name="price" value="<?php echo $book['price']; ?>" required><br><br>

                    <label for="book_image">Book Image:</label>
                    <div class="image-container">
                        <input type="file" name="book_image"><br><br>
                        
                        <img src="books/<?php echo $book['book_image']; ?>?t=<?php echo time(); ?>" width="100" class="book-img"><br><br>
                    </div>

                    <div class="button-container">
                        <input type="submit" value="Update Book" class="btn btn-success" onclick="return confirm('Confirm changes?')">
                        <a href="manage_book.php" class="btn btn-danger">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>
</html>






 





