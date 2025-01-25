<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");  // Redirect if not logged in
    exit();
}


include 'db.php';

$user_id = $_SESSION['user_id'];


$sql = "SELECT books.ID, books.Title, books.Description, books.Genre, books.Author 
        FROM books 
        JOIN carts ON books.ID = carts.book_id 
        WHERE carts.user_id = $user_id";
$result = mysqli_query($conn, $sql);
$cart_books = mysqli_fetch_all($result, MYSQLI_ASSOC);


if (isset($_GET['return_id'])) {
    $book_id = $_GET['return_id'];

    
    $update_status_sql = "UPDATE books SET status = 'available' WHERE ID = $book_id";
    mysqli_query($conn, $update_status_sql);

    
    $remove_from_cart_sql = "DELETE FROM carts WHERE user_id = $user_id AND book_id = $book_id";
    mysqli_query($conn, $remove_from_cart_sql);

    
    $history_sql = "INSERT INTO users_history (user_id, book_id, action, created_at) 
                    VALUES ('$user_id', '$book_id', 'Returned Book', NOW())";
    mysqli_query($conn, $history_sql);

    
    header("Location: cart.php?status=returned");
    exit();
}


if (isset($_GET['add_to_cart'])) {
    $book_id = $_GET['add_to_cart'];

    
    $add_to_cart_sql = "INSERT INTO carts (user_id, book_id) VALUES ('$user_id', '$book_id')";
    mysqli_query($conn, $add_to_cart_sql);

    
    $history_sql = "INSERT INTO users_history (user_id, book_id, action, created_at) 
                    VALUES ('$user_id', '$book_id', 'Added to Cart', NOW())";
    mysqli_query($conn, $history_sql);

    
    header("Location: cart.php?status=added");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
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
                <h2>Your Cart</h2>
            </div>

            <div class="content">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Genre</th>
                            <th>Author</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($cart_books)) : ?>
                            <?php foreach ($cart_books as $book) : ?>
                                <tr>
                                    <td><?php echo $book['ID']; ?></td>
                                    <td><?php echo $book['Title']; ?></td>
                                    <td><?php echo $book['Description']; ?></td>
                                    <td><?php echo $book['Genre']; ?></td>
                                    <td><?php echo $book['Author']; ?></td>
                                    <td>
                                       
                                        <a href="cart.php?return_id=<?php echo $book['ID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Return book now?')">Return</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6">Your cart is empty.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>






