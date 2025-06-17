<?php 

include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize variables
    $target_dir = "uploads/"; // Relative path to uploads folder
    $imageFileName = basename($_FILES["author_image"]["name"]);
    $imageFileType = strtolower(pathinfo($imageFileName, PATHINFO_EXTENSION));
    
    // Create a unique file name using timestamp
    $newImageFileName = uniqid('', true) . '.' . $imageFileType;
    $image_file = $target_dir . $newImageFileName;

    $uploadOk = 1;

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["author_image"]["tmp_name"]);
    if ($check === false) {
        echo "<script>
        alert('File is not an image !');
        </script>";
        $uploadOk = 0;
    }

    // Check file size (500KB max size)
    if ($_FILES["author_image"]["size"] > 500000) {
        echo "<script>
        alert('Sorry, your file is too large. !');
        </script>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "webp" && $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "<script>
        alert('Sorry, only webp, JPG, JPEG, PNG & GIF files are allowed. !');
        </script>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<script>
        alert('Sorry, your file was not uploaded. !');
        </script>";
    } else {
        // Try to upload file
        if (move_uploaded_file($_FILES["author_image"]["tmp_name"], $image_file)) {
            echo "The file " . htmlspecialchars($newImageFileName) . " has been uploaded.";

            // Proceed with database insert if file upload succeeds
            $author_name = mysqli_real_escape_string($connect, $_POST["author_name"]);
            $nationality = mysqli_real_escape_string($connect, $_POST["nationality"]);
            $author_bio = mysqli_real_escape_string($connect, $_POST["author_bio"]);

            $sql = "INSERT INTO `author`(`author_name`, `nationality`, `author_bio`, `author_image`) 
                    VALUES ('$author_name','$nationality','$author_bio','$image_file')";
                    
            $query = mysqli_query($connect, $sql);

            if ($query) {
                header("Location: author.php?status=author_added");
                exit();
            } else {
                echo "Database insert failed: " . mysqli_error($connect);
            }
        } else {
            echo "<script>
        alert('Sorry, there was an error uploading your file. !');
        </script>";
        }
    }
}

?>