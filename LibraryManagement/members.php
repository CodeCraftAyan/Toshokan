<?php
include 'db.php';
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: admin-login.php");
    exit();
}

// Handle deletion of a member
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    
    // Delete the user with the given id
    $delete_sql = "DELETE FROM `admin_user` WHERE id = $delete_id";
    if (mysqli_query($connect, $delete_sql)) {
        header("Location: members.php"); // Redirect to refresh the members list after deletion
        exit();
    } else {
        echo "Error deleting member: " . mysqli_error($connect);
    }
}

$user_id = $_SESSION['user_id'];
$profile_sql = "SELECT * FROM `admin_user` WHERE id = $user_id";
$profile_query = mysqli_query($connect, $profile_sql);

// Fetch all admin users
$members_sql = "SELECT * FROM `admin_user`";
$members_query = mysqli_query($connect, $members_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toshokan - Members</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .member-table {
            height: 87vh;
            margin: 20px;
            padding: 30px 30px 30px 0;
        }

        .member-list {
            height: 90%;
            overflow-y: scroll;
        }

        .member-list table {
            width: 95%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
        }

        .member-list th, .member-list td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        .member-list th {
            background-color: #333;
            color: white;
            font-weight: bold;
        }

        .member-list td {
            color: #333;
        }

        .member-list tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Hover effects for table rows */
        .member-list tr:hover {
            background-color: #f1f1f1;
        }

        /* Delete button styles */
        .delete-btn {
            background-color: #e74c3c;
            color: white;
            text-decoration: none;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
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
    <?php if (mysqli_num_rows($members_query) > 0) : ?>

    <div class="container">
        <div class="navigation">
            <div class="logo"><h2>Toshokan</h2></div>
            <div class="nav">
                <a href="dashboard.php">Dashboard</a>
                <a href="books.php">Books</a>
                <a href="author.php">Author</a>
                <a href="members.php">Members</a>
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
                                <?php while($profile_row = mysqli_fetch_array($profile_query)) { ?>
                                <h3><?php echo $profile_row["name"]; ?></h3>
                                <p><?php echo $profile_row["role"]; ?></p>
                                <?php } ?>
                            </div>
                        </div>            
                    </div>
                </div>
            </a>
        </div>
        <div class="member-table">
            <div class="add">
                <div class="head">
                    <h1>Members of Toshokan</h1>
                </div>
                <div class="add-btn">
                    <a href="add-member.php"><button type="button">ADD MEMBER</button></a>
                </div>
            </div>
            <div class="member-list">
                <table>
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($member_row = mysqli_fetch_assoc($members_query)) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($member_row["id"]); ?></td>
                                <td><?php echo htmlspecialchars($member_row["name"]); ?></td>
                                <td><?php echo htmlspecialchars($member_row["email"]); ?></td>
                                <td><?php echo htmlspecialchars($member_row["role"]); ?></td>
                                <td>
                                    <a href="members.php?delete_id=<?php echo $member_row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this member?');">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <?php else: ?>
    <p>No members found.</p>
    <?php endif; ?>

</body>
</html>
