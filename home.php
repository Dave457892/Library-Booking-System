<?php
session_start();
//newwwww

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");  
    exit();
}


include 'db.php';


$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Users List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css"> 
</head>
<body>
    <div class="wrapper">
       
        <div class="sidebar">
            <h2>USERS</h2>
            <a href="make.php" class="btn btn-primary mb-3">Add New User</a> 
            <a href="manage_book.php" class="btn btn-info mb-3">Manage Books</a> 
        </div>

      
        <div class="main-content">
            <div class="header">
                <h2>Manage Users</h2>
               
                <a href="logout_confirm.php" class="btn btn-secondary btn-sm">LOG OUT</a>
            </div>

            <div class="content">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Profile Image</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)) : ?>
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <td><?php echo $user['id']; ?></td>
                                    <td><?php echo $user['username']; ?></td>
                                    <td><?php echo $user['email']; ?></td>
                                    <td>
                                        <img src="uploads/<?php echo $user['profile_image']; ?>" width="50" alt="Profile Image">
                                    </td>
                                    <td><?php echo ucfirst($user['role']); ?></td>
                                    <td>
                                        <a href="update.php?id=<?php echo $user['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>

                                <td colspan="6">No users found.</td>
                                
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>


