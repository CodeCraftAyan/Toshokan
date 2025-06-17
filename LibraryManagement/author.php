<?php

session_start();
include "db.php";

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql_delete = "DELETE FROM `author` WHERE id = '$delete_id'";
    mysqli_query($connect, $sql_delete);
    header("Location: author.php");
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
    $sql = "SELECT * FROM `author` WHERE author_name LIKE '%$search_term%' OR nationality LIKE '%$search_term%'";
} else {
    // Fetch all authors if no search term is provided
    $sql = "SELECT * FROM `author`";
}
$query = mysqli_query($connect, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toshokan - Author</title>
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

        /* Search bar styling */
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
        <div class="author">
            <div class="add">
                <div class="head">
                    <h1>Available Authors</h1>
                </div>
                <div class="search">
                    <form action="author.php" method="POST" class="search-form">
                        <input type="search" class="search-box" name="search" id="search" placeholder="Search by Author or Nationality" value="<?php echo htmlspecialchars($search_term); ?>">
                        <button type="submit" class="search-button"><i class="fa fa-search"></i></button>
                    </form>
                </div>
                <div class="add-btn">
                    <a href="add-author.html"><button type="button">ADD AUTHOR</button></a>
                </div>
            </div>
            <div class="author-sec">
                <?php while($row = mysqli_fetch_array($query)) { ?>
                <div class="author-card">
                    <div class="author-card-img">
                        <img src="<?php echo $row["author_image"]; ?>" alt="<?php echo $row["author_name"]; ?>">
                    </div>
                    <div class="author-div">
                        <div class="author-card-desc">
                            <h2 class="author-name"><?php echo $row["author_name"]; ?></h2>
                            <p class="nationality"><?php echo $row["nationality"]; ?></p>
                            <p class="author-bio"><?php echo $row["author_bio"]; ?></p>
                        </div>
                        <div class="edit-delete_btn">
                            <a href="edit-author.php?edit_id=<?php echo $row['id']; ?>"><button class="edit">Edit</button></a>
                            <a href="author.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this Author?');"><button class="delete">Delete</button></a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php else: ?>
        <script> 
            alert("No Authors Found!");
        </script>
    <?php endif; ?>
</body>
</html>
