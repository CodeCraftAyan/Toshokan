<?php

include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize variables
    $target_dir = "uploads/"; // Relative path to uploads folder
    $image_file = $target_dir . basename($_FILES["book_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($image_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["book_image"]["tmp_name"]);
    if ($check === false) {
        echo "<script>
        alert('File is not an image !');
        </script>";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($image_file)) {
        echo "<script>
        alert('Sorry, file already exists. !');
        </script>";
        $uploadOk = 0;
    }

    // Check file size (500KB max size)
    if ($_FILES["book_image"]["size"] > 500000) {
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
        if (move_uploaded_file($_FILES["book_image"]["tmp_name"], $image_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["book_image"]["name"])) . " has been uploaded.";

            // Proceed with database insert if file upload succeeds
            $book_name = $_POST["book_name"];
            $book_author = $_POST["author"];
            $book_rating = $_POST["rating"];

            $sql = "INSERT INTO `books`(`book_name`, `author_name`, `rating`, `book_image`) 
                    VALUES ('$book_name', '$book_author', '$book_rating', '$image_file')";
                    
            $query = mysqli_query($connect, $sql);

            if ($query) {
                header("Location: books.php?status=book_added");
                exit();
            } else {
                echo "<script>
                alert('Database insert failed. !');
                </script>";
            }
        } else {
            echo "<script>
            alert('Sorry, there was an error uploading your file. !');
            </script>";
        }
    }
}

?>
