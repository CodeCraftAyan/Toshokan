<?php

include "db.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: admin-login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$profile_sql = "SELECT * FROM `admin_user` WHERE id = $user_id";
$profile_query = mysqli_query($connect, $profile_sql);
$profile_row = mysqli_fetch_assoc($profile_query);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toshokan - Issued & return</title>
    <link rel="stylesheet" href="style.css">
    <style>
        button{
            margin-top: 50px;
            margin-right: 15px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
        }
        .navigation{
            background: linear-gradient(to right, #1f1e30, #5a5970);
        }
        .edit:hover{
            cursor: pointer;
            background-color: #2dcb15;
        }

        .delete:hover{
            cursor: pointer;
            background-color: #f07388;
        }
    </style>
</head>
<body>
    <?php if (mysqli_num_rows($profile_query) > 0) : ?>
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
                    <div class="profile">
                        <div class="user">
                            <div class="image">
                                <img src="image/dandadan.jpg" alt="" srcset="">
                            </div>
                            <div class="name">
                                <h3><?php echo htmlspecialchars($profile_row["name"]); ?></h3>
                                <p><?php echo htmlspecialchars($profile_row["role"]); ?></p>
                            </div>
                        </div>            
                    </div>
                </div>
            </a>
        </div>
        <div class="issue-return">
        <div class="head">
                    <h1>Book Issue and Return from here</h1>
                </div>
            <a href="issue-book.php"><button class="edit">ISSUE BOOK</button></a>
            <a href="return-book.php"><button class="delete">RETURN BOOK</button></a>
        </div>
    <?php else: ?>
        <script> 
            alert("No Books Found!");
        </script>
    <?php endif; ?>
</body>
</html>