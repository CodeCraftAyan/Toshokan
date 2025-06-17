<?php

include "db.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST["name"];
    $email = $_POST["email"];
    $pass = $_POST["password"];
    $role = $_POST["role"];

    $check_user = "SELECT * FROM `admin_user` WHERE email='$email'";
    $check_query = mysqli_query($connect, $check_user);

    if(mysqli_num_rows($check_query) > 0){
        header("Location: index.html?status=same_user");
    }else{
        $hash_password = password_hash($pass, PASSWORD_DEFAULT);

        $sql = "INSERT INTO `admin_user`(`name`, `email`, `password`, `role`) VALUES ('$name','$email','$hash_password','$role')";
        $query = mysqli_query($connect, $sql);

        if($query){
            header("Location: index.html?status=success");
            exit();
        }else{
            header("Location: index.html?status=not success");
            exit();
        }
    }
}

?>