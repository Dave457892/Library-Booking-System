<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] === 'admin') {
    header("Location: index.php");
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
    <title>Available Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="wrapper">
        <div class="sidebar">
            <h2>BOOKS</h2>
            <a href="index.php" class="btn btn-info mb-3">Home</a>
        </div>

        <div class="main-content">
            <div class="header">
                <h2>Available Books</h2>
            </div>

            <div class="content">
                <?php if (isset($_GET['status']) && $_GET['status'] == 'success') : ?>
                    <div class="alert alert-success">Book rented successfully!</div>
                <?php elseif (isset($_GET['status']) && $_GET['status'] == 'unavailable') : ?>
                    <div class="alert alert-danger">Sorry, this book is unavailable.</div>
                <?php endif; ?>

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
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
                                        <?php if ($book['status'] == 'available') : ?>
                                            <a href="book_detail.php?book_id=<?php echo $book['ID']; ?>" class="btn btn-info btn-sm">View</a>
                                        <?php else : ?>
                                            <span class="text-muted">Already Rented</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6">No books available.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>


