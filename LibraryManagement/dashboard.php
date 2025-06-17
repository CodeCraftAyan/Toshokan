<?php
include 'db.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: admin-login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch profile data
$profile_sql = "SELECT * FROM `admin_user` WHERE id = $user_id";
$profile_query = mysqli_query($connect, $profile_sql);

if (!$profile_query) {
    die("Profile query failed: " . mysqli_error($connect));
}
$profile_row = mysqli_fetch_assoc($profile_query);  // Fetch profile data once

// Fetch total, available, and borrowed books
$total_books_sql = "SELECT COUNT(*) AS total_books FROM `books`";
$total_books_query = mysqli_query($connect, $total_books_sql);
$total_books_row = mysqli_fetch_assoc($total_books_query);
$total_books = $total_books_row['total_books'];

// Available books: Total books - Borrowed books
$available_books_sql = "SELECT COUNT(*) AS available_books FROM `books` 
                        WHERE id NOT IN (SELECT book_id FROM borrows WHERE status = 'issued')";
$available_books_query = mysqli_query($connect, $available_books_sql);
$available_books_row = mysqli_fetch_assoc($available_books_query);
$available_books = $available_books_row['available_books'];

// Total borrowed books
$borrowed_books_sql = "SELECT COUNT(*) AS borrowed_books FROM `borrows` WHERE status = 'issued'";
$borrowed_books_query = mysqli_query($connect, $borrowed_books_sql);
$borrowed_books_row = mysqli_fetch_assoc($borrowed_books_query);
$borrowed_books = $borrowed_books_row['borrowed_books'];

// Total authors
$total_authors_sql = "SELECT COUNT(*) AS total_authors FROM `author`";
$total_authors_query = mysqli_query($connect, $total_authors_sql);
$total_authors_row = mysqli_fetch_assoc($total_authors_query);
$total_authors = $total_authors_row['total_authors'];

// Total returned books
$returned_books_sql = "SELECT COUNT(*) AS returned_books FROM `borrows` WHERE status = 'returned'";
$returned_books_query = mysqli_query($connect, $returned_books_sql);
$returned_books_row = mysqli_fetch_assoc($returned_books_query);
$returned_books = $returned_books_row['returned_books'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toshokan - Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .profile{
            bottom: 60px;
        }
        .user{
            gap: 24px;
        }
        .navigation{
            background: linear-gradient(to right, #1f1e30, #5a5970);
        }
        .color{
            margin-right: 15px;
        }
    </style>
</head>
<body>
    <?php if ($profile_row) : ?>
    <div class="container">
        <div class="navigation">
            <div class="logo"><h2>Toshokan</h2></div>
            <div class="nav">
                <a href="dashboard.php">Dashboard</a>
                <a href="books.php">Books</a>
                <a href="author.php">Author</a>
                <!-- Only show 'Members' tab if the role is Admin or Librarian -->
                <?php if ($profile_row['role'] === 'admin' || $profile_row['role'] === 'librarian') : ?>
                    <a href="members.php">Members</a>
                    <a href="view-borrows.php">Borrows</a>
                <?php endif; ?>
                <a href="issue-return.php">Issued & Return</a>
            </div>
            <a href="profile.php">
                <div class="profile">
                    <div class="user">
                        <div class="image">
                            <img src="image/dandadan.jpg" alt="">
                        </div>
                        <div class="name">
                            <h3><?php echo htmlspecialchars($profile_row["name"]); ?></h3>
                            <p><?php echo htmlspecialchars($profile_row["role"]); ?></p>
                        </div>
                    </div>            
                </div>
            </a>
        </div>
        <div class="dashboard">
            <div class="add">
                <div class="head">
                    <h1>Welcome, <?php echo htmlspecialchars($profile_row["name"]); ?></h1>
                    <p>We’re excited to have you back! Let’s make today productive and inspiring.</p>
                </div>
                <div class="add-btn">
                    <a href="logout.php"><button type="button">LOG OUT</button></a>
                </div>
            </div>
            <div class="left-side">
                <div class="box box2">
                    <div class="color booked">
                        <h1 class="total-book">Total Books</h1>
                        <h2 class="total-no"><?php echo htmlspecialchars($total_books); ?></h2>
                    </div>
                    <div class="color success">
                        <h1 class="available-book">Available Books</h1>
                        <h2 class="available-no"><?php echo htmlspecialchars($available_books); ?></h2>
                    </div>
                    <div class="color borrow-color">
                        <h1 class="total-borrows">Total Borrows</h1>
                        <h2 class="borrows-no"><?php echo htmlspecialchars($borrowed_books); ?></h2>
                    </div>
                </div>
                <div class="box box2">
                    <div class="color return">
                        <h1 class="total-return">Returned Books</h1>
                        <h2 class="total-no"><?php echo htmlspecialchars($returned_books); ?></h2>
                    </div>
                    <div class="color author-color">
                        <h1 class="total-author">Total Authors</h1>
                        <h2 class="available-no"><?php echo htmlspecialchars($total_authors); ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php else: ?>
        <script> 
            alert("No Data Found!");
        </script>
    <?php endif; ?>
</body>
</html>
