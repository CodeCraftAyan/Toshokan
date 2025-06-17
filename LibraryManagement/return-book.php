<?php
$server = "localhost";
$user = "root";
$pass = "";
$db = "toshokan";

$connect = mysqli_connect($server, $user, $pass, $db);

if (!$connect) {
    die("Connection Error: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $borrow_id = mysqli_real_escape_string($connect, $_POST['borrow_id']);
    $return_date = date('Y-m-d');

    // Update the `borrows` table
    $sql = "UPDATE `borrows` SET `return_date` = '$return_date', `status` = 'returned' 
            WHERE `borrow_id` = '$borrow_id' AND `status` = 'issued'";

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
    <title>Toshokan - Return Book</title>
    <link rel="stylesheet" href="add-book.css"><style>
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
            <!-- HTML Form to Return a Book -->
            <form action="return-book.php" method="POST">
                <label for="borrow_id">Borrow ID:</label>
                <input type="number" name="borrow_id" required>

                <input type="submit" value="Return Book">
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
