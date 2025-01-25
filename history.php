<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); 
    exit();
}


include 'db.php';

$user_id = $_SESSION['user_id'];


$sql = "SELECT books.ID, books.Title, books.Genre, books.Author, users_history.action, users_history.created_at, users_history.id AS history_id
        FROM users_history
        JOIN books ON books.ID = users_history.book_id
        WHERE users_history.user_id = $user_id";
$result = mysqli_query($conn, $sql);
$history_books = mysqli_fetch_all($result, MYSQLI_ASSOC);


if (isset($_GET['delete_history'])) {
    $history_id = $_GET['delete_history'];

   
    $history_id = intval($history_id);

    
    $delete_history_sql = "DELETE FROM users_history WHERE id = '$history_id' AND user_id = '$user_id'";
    mysqli_query($conn, $delete_history_sql);

    
    header("Location: history.php?status=deleted");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="wrapper">
       
        <div class="sidebar">
            <h2>BOOKS</h2>
            <a href="dashboard.php" class="btn btn-info mb-3">Home</a>
        </div>

       
        <div class="main-content">
            <div class="header">
                <h2>History</h2>
            </div>

            <div class="content">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Genre</th>
                            <th>Author</th>
                            <th>Action</th>
                            <th>Rented at</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($history_books)) : ?>
                            <?php foreach ($history_books as $history) : ?>
                                <tr>
                                    <td><?php echo $history['ID']; ?></td>
                                    <td><?php echo $history['Title']; ?></td>
                                    <td><?php echo $history['Genre']; ?></td>
                                    <td><?php echo $history['Author']; ?></td>
                                    <td><?php echo $history['action']; ?></td>
                                    <td><?php echo date("m-d-Y H:i", strtotime($history['created_at'])); ?></td>
                                    <td>
                                       
                                        <a href="history.php?delete_history=<?php echo $history['history_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this history entry?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="7">Your history is empty.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>





