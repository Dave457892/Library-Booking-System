<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php");  
    exit();
}

include 'db.php';

$sql = "SELECT * FROM books"; 
$result = mysqli_query($conn, $sql);
$books = mysqli_fetch_all($result, MYSQLI_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css"> 

    <style>
       
        img {
            border-radius: 10px;  
            object-fit: cover;    
        }
    </style>

</head>
<body>
    <div class="wrapper">
        <div class="sidebar">
            <h2>BOOKS</h2>
            <a href="add_book.php" class="btn btn-primary mb-3">Add New Book</a>  
            <a href="index.php" class="btn btn-info mb-3">Go Back</a>  
        </div>

        <div class="main-content">
            <div class="header">
                <h2>Manage Books</h2>
            </div>

            <div class="content">
               

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Genre</th>
                            <th>Author</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($books)) : ?>
                            <?php foreach ($books as $book) : ?>
                                <tr>
                                    <td><?php echo $book['ID']; ?></td>
                                    <td><?php echo $book['Title']; ?></td>
                                    <td><?php echo $book['Genre']; ?></td>
                                    <td><?php echo $book['Author']; ?></td>
                                    <td>
                                    <img src="books/<?php echo $book['book_image']; ?>" alt="Book Image" width="100">
                                    </td>

                                    <td>
                                        <span class="badge <?php echo $book['status'] == 'available' ? 'bg-success' : 'bg-danger'; ?>">
                                            <?php echo ucfirst($book['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="update_book.php?id=<?php echo $book['ID']; ?>" class="btn btn-warning btn-sm">Edit</a>

                                   
                                        <?php if ($book['status'] == 'available') : ?>
                                            <a href="delete_book.php?id=<?php echo $book['ID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this book?')">Delete</a>
                                        <?php else : ?>
                                           
                                            <span class="text-muted">Book currently rented</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?> 
                            <tr>
                                <td colspan="8">No books found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>






