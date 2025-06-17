<?php

include "db.php";

if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];

    // Fetch the current author details
    $sql = "SELECT * FROM `author` WHERE id = '$edit_id'";
    $result = mysqli_query($connect, $sql);
    $author = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize variables
    $author_name = mysqli_real_escape_string($connect, $_POST["author_name"]);
    $nationality = mysqli_real_escape_string($connect, $_POST["nationality"]);
    $author_bio = mysqli_real_escape_string($connect, $_POST["author_bio"]);
    $image_file = $author["author_image"]; // Keep old image if not uploaded again

    // If a new image is uploaded
    if (isset($_FILES["author_image"]) && $_FILES["author_image"]["error"] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/"; // Relative path to uploads folder
        $imageFileName = basename($_FILES["author_image"]["name"]);
        $imageFileType = strtolower(pathinfo($imageFileName, PATHINFO_EXTENSION));
        $newImageFileName = uniqid('', true) . '.' . $imageFileType;
        $image_file = $target_dir . $newImageFileName;

        // Move the uploaded file
        if (move_uploaded_file($_FILES["author_image"]["tmp_name"], $image_file)) {
            // Successfully uploaded image
        } else {
            echo "<script>
            alert('Error uploading image. !');
            </script>";
        }
    }

    // Update the author details
    $sql_update = "UPDATE `author` SET `author_name` = '$author_name', `nationality` = '$nationality', `author_bio` = '$author_bio', `author_image` = '$image_file' WHERE `id` = '$edit_id'";

    // Debugging output
    // Uncomment the line below to see the SQL query for debugging purposes
    // echo "SQL Query: " . htmlspecialchars($sql_update); 

    if (mysqli_query($connect, $sql_update)) {
        header("Location: author.php?status=author_updated");
        exit();
    } else {
        echo "Update failed: " . mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Author - Toshokan</title>
    <link rel="stylesheet" href="add-book.css">
</head>
<body>
    <div id="container">
        <div class="form">
            <h1>Edit Author Details</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <label for="author_name">Author Name </label>
                <input type="text" id="author_name" name="author_name" value="<?php echo htmlspecialchars($author['author_name']); ?>" required>

                <label for="nationality">Nationality </label>
                <select id="nationality" name="nationality" required>
                    <option value="" disabled>Select Nationality</option>
                    <option value="indian" <?php echo ($author['nationality'] == 'indian') ? 'selected' : ''; ?>>Indian</option>
                    <option value="american" <?php echo ($author['nationality'] == 'american') ? 'selected' : ''; ?>>American</option>
                    <option value="british" <?php echo ($author['nationality'] == 'british') ? 'selected' : ''; ?>>British</option>
                    <option value="australian" <?php echo ($author['nationality'] == 'australian') ? 'selected' : ''; ?>>Australian</option>
                    <option value="canadian" <?php echo ($author['nationality'] == 'canadian') ? 'selected' : ''; ?>>Canadian</option>
                    <option value="french" <?php echo ($author['nationality'] == 'french') ? 'selected' : ''; ?>>French</option>
                    <option value="german" <?php echo ($author['nationality'] == 'german') ? 'selected' : ''; ?>>German</option>
                    <option value="chinese" <?php echo ($author['nationality'] == 'chinese') ? 'selected' : ''; ?>>Chinese</option>
                    <option value="japanese" <?php echo ($author['nationality'] == 'japanese') ? 'selected' : ''; ?>>Japanese</option>
                    <option value="mexican" <?php echo ($author['nationality'] == 'mexican') ? 'selected' : ''; ?>>Mexican</option>
                    <option value="brazilian" <?php echo ($author['nationality'] == 'brazilian') ? 'selected' : ''; ?>>Brazilian</option>
                    <option value="south_korean" <?php echo ($author['nationality'] == 'south_korean') ? 'selected' : ''; ?>>South Korean</option>
                    <option value="italian" <?php echo ($author['nationality'] == 'italian') ? 'selected' : ''; ?>>Italian</option>
                    <option value="spanish" <?php echo ($author['nationality'] == 'spanish') ? 'selected' : ''; ?>>Spanish</option>
                    <option value="russian" <?php echo ($author['nationality'] == 'russian') ? 'selected' : ''; ?>>Russian</option>
                    <option value="south_african" <?php echo ($author['nationality'] == 'south_african') ? 'selected' : ''; ?>>South African</option>
                    <option value="other" <?php echo ($author['nationality'] == 'other') ? 'selected' : ''; ?>>Other</option>
                </select>

                <label for="author_bio">Bio </label>
                <textarea id="author_bio" name="author_bio" rows="4" cols="50" required><?php echo htmlspecialchars($author['author_bio']); ?></textarea>

                <label>Profile Image (Leave blank to keep current image)</label>
                <input type="file" id="author_image" name="author_image" accept="image/*">

                <input type="submit" value="UPDATE AUTHOR">
            </form>
        </div>
    </div> 
</body>
</html>
