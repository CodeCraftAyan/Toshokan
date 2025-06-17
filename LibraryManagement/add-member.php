<?php
session_start();
include "db.php";

// Initialize variables for form handling
$name = $email = $password = $role = "";
$errors = [];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $name = mysqli_real_escape_string($connect, trim($_POST['name']));
    $email = mysqli_real_escape_string($connect, trim($_POST['email']));
    $password = mysqli_real_escape_string($connect, trim($_POST['password']));
    $role = mysqli_real_escape_string($connect, trim($_POST['role']));

    // Simple validation
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }
    if (empty($role) || !in_array($role, ['admin', 'librarian', 'member'])) {
        $errors[] = "Valid role is required (admin, librarian, member).";
    }

    // Check if there are no errors
    if (empty($errors)) {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert into the database
        $sql = "INSERT INTO `admin_user` (name, email, password, role) VALUES ('$name', '$email', '$hashed_password', '$role')";
        if (mysqli_query($connect, $sql)) {
            // Redirect to the members list or show a success message
            header("Location: members.php?success=1");
            exit();
        } else {
            $errors[] = "Failed to add member: " . mysqli_error($connect);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Member - Toshokan</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="add-book.css">
    <style>
        label {
            display: block; /* Make labels take full width */
            margin-bottom: 5px; /* Space below the label */
            font-weight: bold; /* Bold labels */
        }
        input, .add-member-btn {
            width: 100%; /* Full width for input fields */
            padding: 10px; /* Padding inside input fields */
            margin-bottom: 15px; /* Space below each input */
            border: 1px solid #ccc; /* Light grey border */
            border-radius: 5px; /* Rounded corners for inputs */
            font-size: 16px; /* Slightly larger font size */
        }
        .add-member-btn {
            background-color: #007bff; /* Blue background for the submit button */
            color: white; /* White text for the button */
            border: none; /* No border for the button */
            cursor: pointer; /* Pointer cursor on hover */
            transition: background-color 0.3s; /* Smooth background change on hover */
        }

        .add-member-btn:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
        .back-button {
            margin-top: 30px;
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
        
        <?php if (!empty($errors)) : ?>
            <div class="error-messages">
                <ul>
                    <?php foreach ($errors as $error) : ?>
                        <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
                
        <div class="form">
            <h1>Add New Member</h1>
            <form action="add-member.php" method="POST">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="role">Role:</label>
                    <select id="role" name="role" required>
                        <option value="">Select Role</option>
                        <option value="admin" <?php echo ($role == 'admin') ? 'selected' : ''; ?>>Admin</option>
                        <option value="librarian" <?php echo ($role == 'librarian') ? 'selected' : ''; ?>>Librarian</option>
                        <option value="member" <?php echo ($role == 'member') ? 'selected' : ''; ?>>Member</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="add-member-btn">Add Member</button>
                </div>
            </form>
       </div>

       <button class="back-button" onclick="goBack()">Go Back</button>
       <script>
            function goBack() {
                window.history.back();
            }
        </script>

    </div>
</body>
</html>
