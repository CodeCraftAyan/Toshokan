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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Card</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
        }

        .profile-card {
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            background-color: #fff;
            margin-bottom: 20px;
        }

        .profile-image {
            width: 200px; /* Make sure width is equal to height */
            height: 200px; /* Make sure height is equal to width */
            border-radius: 50%; /* Creates the round shape */
            object-fit: cover; /* Ensures the image covers the area */
            margin-bottom: 15px;
        }

        .profile-info {
            text-align: center;
        }

        .profile-name {
            font-size: 1.5em;
            margin: 0;
        }

        .profile-id, .profile-role {
            font-size: 1em;
            color: #555;
            margin: 5px 0;
        }

        .back-button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .back-button:hover {
            background-color: #0056b3;
        }

        .btn{
            display: flex;
            gap: 20px;
        }
    </style>
</head>
<body>
    <?php if (mysqli_num_rows($profile_query) > 0) : ?>
    <div class="profile-card">
        <img src="image/dandadan.jpg" alt="Profile Picture" class="profile-image">
        <div class="profile-info">
            <?php $profile_row = mysqli_fetch_array($profile_query); ?>
                <h2 class="profile-name"><?php echo htmlspecialchars($profile_row["name"]); ?></h2>
                <p class="profile-id">User ID: <?php echo htmlspecialchars($profile_row["id"]); ?></p>
                <p class="profile-role">Role: <?php echo htmlspecialchars($profile_row["role"]); ?></p>
        </div>
    </div>

    <div class="btn">
        <button class="back-button" onclick="goBack()">Go Back</button>
        <a href="logout.php"><button class="back-button">Log Out</button></a>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>

    <?php else: ?>
    <script> 
        alert("No Data Found!");
    </script>
    <?php endif; ?>
</body>
</html>
