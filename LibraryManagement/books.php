<?php

session_start();
include "db.php";

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql_delete = "DELETE FROM `books` WHERE id = '$delete_id'";
    mysqli_query($connect, $sql_delete);
    header("Location: books.php");
    exit();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: admin-login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$profile_sql = "SELECT * FROM `admin_user` WHERE id = $user_id";
$profile_query = mysqli_query($connect, $profile_sql);
$profile_row = mysqli_fetch_assoc($profile_query);

// Search functionality
$search_term = '';
if (isset($_POST['search'])) {
    $search_term = mysqli_real_escape_string($connect, $_POST['search']);
    $sql = "SELECT * FROM `books` WHERE book_name LIKE '%$search_term%' OR author_name LIKE '%$search_term%'";
} else {
    // Fetch all books if no search term is provided
    $sql = "SELECT * FROM `books`";
}
$query = mysqli_query($connect, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toshokan - Books</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .navigation {
            background: linear-gradient(to right, #1f1e30, #5a5970);
        }
        .edit:hover {
            cursor: pointer;
            background-color: #2dcb15;
        }

        .delete:hover {
            cursor: pointer;
            background-color: #f07388;
        }

        .head, .add-btn{
            width: 30%;
        }
        .search{
            width: 40%;
        }
        .search-form {
            width: 100%;
            display: flex;
            justify-content: center;
        }
        
        .search-box{
            width: 85%;
            padding: 10px 20px;
            border: none;
            border-radius: 20px 0 0 20px;
        }

        .search-button{
            width: 15%;
            padding: 10px 20px;
            border: none;
            border-radius: 0 20px 20px 0;
            background-color: #023047;
            color: #f3f3f3;
            cursor: pointer; 
        }

        .search-button:hover{
            background-color: #0369a1;
        }

        .profile{
            bottom: 60px;
        }
        .user{
            gap: 24px;
        }
    </style>
</head>
<body>
    <?php if (mysqli_num_rows($query) > 0) : ?>
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

        <div class="books">
            <div class="add">
                <div class="head">
                    <h1>Available Books</h1>
                </div>
                <div class="search">
                    <form action="books.php" method="POST" class="search-form">
                        <input type="search" class="search-box" name="search" id="search" placeholder="Search by Book or Author" value="<?php echo htmlspecialchars($search_term); ?>">
                        <button type="submit" class="search-button"><i class="fa fa-search"></i></button>
                    </form>
                </div>
                <div class="add-btn">
                    <a href="add-book.html"><button type="button">ADD BOOK</button></a>
                </div>
            </div>

            <div class="book">
                <?php while ($row = mysqli_fetch_array($query)) { ?>
                <div class="card">
                    <div class="card-img">
                        <img src="<?php echo $row["book_image"]; ?>" alt="<?php echo $row["book_name"]; ?>">
                    </div>
                    <div class="card-desc">
                        <h2 class="book-name"><?php echo $row["book_name"]; ?></h2>
                        <div class="flex">
                            <p class="author-name"><?php echo $row["author_name"]; ?></p>
                            <p class="rating"><span class="star" style="color: rgb(255, 217, 0);">★</span><?php echo $row["rating"]; ?></p>
                        </div>
                        <div class="flex-2">
                            <p class="book-id">Book ID</p>
                            <p class="id"><?php echo $row["id"]; ?></p>
                        </div>
                    </div>
                    <div class="edit-delete_btn">
                        <a href="edit-book.php?edit_id=<?php echo $row['id']; ?>"><button class="edit">Edit</button></a>
                        <a href="books.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this book?');"><button class="delete">Delete</button></a>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php else: ?>
        <script> 
            alert("No Books Found!");
        </script>
    <?php endif; ?>
</body>
</html>
