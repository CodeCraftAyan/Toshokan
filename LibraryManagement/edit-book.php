<?php

include "db.php";

// Initialize variables
$edit_book = null;

// Handle form submission for updating the book
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = $_POST['book_id'];
    $book_name = $_POST["book_name"];
    $book_author = $_POST["author"];
    $book_rating = $_POST["rating"];
    $image_file = $_POST["existing_image"]; // Preserve existing image

    // Only update the image if a new one is uploaded
    if (isset($_FILES["book_image"]) && $_FILES["book_image"]["size"] > 0) {
        $target_dir = "uploads/";
        $image_file = $target_dir . basename($_FILES["book_image"]["name"]);
        move_uploaded_file($_FILES["book_image"]["tmp_name"], $image_file);
    }

    // Update the database
    $sql = "UPDATE `books` SET `book_name`='$book_name', `author_name`='$book_author', `rating`='$book_rating', `book_image`='$image_file' WHERE id='$book_id'";
    
    if (mysqli_query($connect, $sql)) {
        header("Location: books.php?status=book_updated");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($connect);
    }
}

// Fetch book data for editing
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $sql_edit = "SELECT * FROM `books` WHERE id = '$edit_id'";
    $result_edit = mysqli_query($connect, $sql_edit);

    if ($result_edit) {
        $edit_book = mysqli_fetch_assoc($result_edit);
    } else {
        echo "Error fetching record: " . mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toshokan - Edit Book</title>
    <link rel="stylesheet" href="add-book.css">
</head>
<body>
    <div id="container">
        <div class="form">
            <h1>Toshokan - Edit Book</h1>
            <?php if ($edit_book): ?>
            <form action="edit-book.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="book_id" value="<?php echo $edit_book['id']; ?>">
                <input type="hidden" name="existing_image" value="<?php echo $edit_book['book_image']; ?>">
                
                <label>Book Name</label>
                <input type="text" name="book_name" id="book_name" value="<?php echo htmlspecialchars($edit_book['book_name']); ?>" required>
                
                <label>Book Author</label>
                <input type="text" name="author" id="author" value="<?php echo htmlspecialchars($edit_book['author_name']); ?>" required>
                
                <label>Book Rating</label>
                <input type="number" id="rating" name="rating" value="<?php echo $edit_book['rating']; ?>" min="0" max="10" step="0.1" required>
                
                <label>Book Front Page (leave blank to keep current image)</label>
                <input type="file" id="book_image" name="book_image" accept="image/*">
                
                <input type="submit" value="Update Book">
            </form>
            <?php else: ?>
                <p>Book not found!</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
