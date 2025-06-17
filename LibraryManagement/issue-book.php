<?php

include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = mysqli_real_escape_string($connect, $_POST['admin_id']);
    $book_id = mysqli_real_escape_string($connect, $_POST['book_id']);
    $borrow_date = date('Y-m-d');
    $due_date = date('Y-m-d', strtotime($borrow_date. ' + 14 days')); // 14-day borrowing period

    $sql = "INSERT INTO `borrows` (admin_id, book_id, borrow_date, due_date) 
            VALUES ('$admin_id', '$book_id', '$borrow_date', '$due_date')";

    if (mysqli_query($connect, $sql)) {
        header("Location: view-borrows.php");
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toshokan - Issued Book</title>
    <link rel="stylesheet" href="add-book.css">
    <style>
        #container{
            flex-direction: column;
        }
        .back-button {
            margin-top: 50px;
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
    </style>
</head>
<body>
    <div id="container">
        <div class="form">
            <!-- HTML Form to Issue a Book -->
            <form action="issue-book.php" method="POST">
                <label for="admin_id">Admin User ID:</label>
                <input type="number" name="admin_id" required>
                
                <label for="book_id">Book ID:</label>
                <input type="number" name="book_id" required>

                <input type="submit" value="Issue Book">
            </form>
        </div>
        <button class="back-button" onclick="goBack()">Go Back</button>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
