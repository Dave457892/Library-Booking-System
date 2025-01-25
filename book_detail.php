<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header("Location: login.php");
    exit();
}

include 'db.php';

if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];

    $sql = "SELECT * FROM books WHERE ID = $book_id";
    $result = mysqli_query($conn, $sql);
    $book = mysqli_fetch_assoc($result);

    if (!$book) {
        echo "Book not found.";
        exit();
    }
} else {
    echo "No book selected.";
    exit();
}

if (isset($_GET['rent_id'])) {
    $user_id = $_SESSION['user_id'];

    $book_check_sql = "SELECT status FROM books WHERE ID = $book_id";
    $book_result = mysqli_query($conn, $book_check_sql);
    $book_status = mysqli_fetch_assoc($book_result)['status'];

    if ($book_status === 'available') {
        $update_status_sql = "UPDATE books SET status = 'unavailable' WHERE ID = $book_id";
        if (mysqli_query($conn, $update_status_sql)) {
            $add_to_cart_sql = "INSERT INTO carts (user_id, book_id) VALUES ($user_id, $book_id)";
            if (mysqli_query($conn, $add_to_cart_sql)) {
                header("Location: browse.php?status=success");
                exit();
            } else {
                echo "Error adding book to cart: " . mysqli_error($conn);
            }
        } else {
            echo "Error updating book status: " . mysqli_error($conn);
        }
    } else {
        header("Location: browse.php?status=unavailable");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="detail.css"> <!-- Link to custom CSS -->
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Profile section with image, username, and role -->
            <div class="profile">
                <!-- Use profile image from session data and force the size inline -->
                <img src="uploads/<?php echo $_SESSION['profile_image']; ?>" alt="Profile Picture" class="profile-pic" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; border: 2px solid #ddd;">
                <div class="user-info">
                    <!-- Make username clickable, redirect to user profile -->
                    <h3><a href="user_profile.php"><?php echo $_SESSION['username']; ?></a></h3>
                    <p class="role"><?php echo ucfirst($_SESSION['role']); ?></p>
                </div>
            </div>

            <ul>
                <li><a href="browse.php">View Books</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="logout_confirm.php">Logout</a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="main-header">
                <h2>Book Details</h2>
            </div>

            <div class="content">
                <div class="row">
                    <div class="col-md-6">
                        <img src="books/<?php echo $book['book_image']; ?>" alt="Book Image" width="100%">
                    </div>
                    <div class="col-md-6">
                        <h3><?php echo $book['Title']; ?></h3>
                        <p><strong>Author:</strong> <?php echo $book['Author']; ?></p>
                        <p><strong>Description:</strong> <?php echo $book['Description']; ?></p>
                        <p><strong>Status:</strong> <?php echo ucfirst($book['status']); ?></p>

                        <div class="book-price-box">
                            <h4>Price: P<?php echo number_format($book['price'], 2); ?></h4>
                            <div class="payment-method">
                                <label for="payment-method">Choose a payment method:</label>
                                <select id="payment-method" class="form-select">
                                    <option value="paypal">PayPal</option>
                                    <option value="credit-card">Credit Card</option>
                                    <option value="stripe">Stripe</option>
                                    <option value="bank-transfer">Bank Transfer</option>
                                </select>
                            </div>
                        </div>

                        <div class="book-action-buttons">
                            <?php if ($book['status'] == 'available') : ?>
                                <a href="book_detail.php?book_id=<?php echo $book['ID']; ?>&rent_id=<?php echo $book['ID']; ?>" class="btn btn-primary btn-sm btn-rent" onclick="return confirm('Rent this book?')">Rent</a>
                            <?php else : ?>
                                <span class="text-muted">Unavailable</span>
                            <?php endif; ?>
                            <a href="browse.php" class="btn btn-sm btn-back">Back to Book List</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>




