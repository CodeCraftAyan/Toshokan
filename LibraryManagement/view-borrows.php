<?php

session_start();
include "db.php";

// Check if delete is requested
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM borrows WHERE borrow_id = $delete_id";
    mysqli_query($connect, $delete_sql);
    // Redirect to the same page to avoid resubmission of form on refresh
    header("Location: view-borrows.php");
}

if (!isset($_SESSION['user_id'])) {
    header("Location: admin-login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$profile_sql = "SELECT * FROM `admin_user` WHERE id = $user_id";
$profile_query = mysqli_query($connect, $profile_sql);
$profile_row = mysqli_fetch_assoc($profile_query);

$sql = "SELECT borrows.borrow_id, admin_user.name AS admin_name, books.book_name, borrows.borrow_date, borrows.due_date, borrows.return_date, borrows.status 
        FROM borrows
        JOIN admin_user ON borrows.admin_id = admin_user.id
        JOIN books ON borrows.book_id = books.id";

$query = mysqli_query($connect, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toshokan - Borrowed Books</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .borrows{
            height: 87vh;
            margin: 20px;
            padding: 30px 30px 30px 0;
        }
        .borrow{
            height: 90%;
            overflow-y: scroll;
        }
        .borrow table {
            width: 95%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
        }

        .borrow th, .borrow td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        .borrow th {
            background-color: #333;
            color: white;
            font-weight: bold;
        }

        .borrow td {
            color: #333;
        }

        .borrow tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Hover effects for table rows */
        .borrow tr:hover {
            background-color: #f1f1f1;
        }

        /* Delete button styles */
        .delete-btn {
            background-color: #e74c3c;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }
        .delete-btn:hover {
            background-color: #c0392b;
        }
        .navigation{
            background: linear-gradient(to right, #1f1e30, #5a5970);
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
                <?php endif; ?>
                <a href="view-borrows.php">Borrows</a>
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
        <div class="borrows">
            <div class="add">
                <div class="head">
                    <h1>Borrowed Books</h1>
                </div>
            </div>
            <div class="borrow">
            <table>
                <tr>
                    <th>Borrow ID</th>
                    <th>Admin Name</th>
                    <th>Book Name</th>
                    <th>Borrow Date</th>
                    <th>Due Date</th>
                    <th>Return Date</th>
                    <th>Status</th>
                    <th>Delete</th> <!-- New Delete header -->
                </tr>
                <?php while ($row = mysqli_fetch_assoc($query)) { ?>
                <tr>
                    <td><?php echo $row['borrow_id']; ?></td>
                    <td><?php echo $row['admin_name']; ?></td>
                    <td><?php echo $row['book_name']; ?></td>
                    <td><?php echo $row['borrow_date']; ?></td>
                    <td><?php echo $row['due_date']; ?></td>
                    <td><?php echo $row['return_date'] ? $row['return_date'] : 'Not Returned'; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>
                        <!-- Delete button -->
                        <a class="delete-btn" href="view-borrows.php?delete_id=<?php echo $row['borrow_id']; ?>">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </table>
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
