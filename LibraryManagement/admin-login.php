<?php

session_start();

include "db.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST["email"];
    $pass = $_POST["password"];

    $sql = "SELECT * FROM `admin_user` WHERE email='$email'";
    $query = mysqli_query($connect, $sql);

    if($query){
        if(mysqli_num_rows($query) > 0){
            $user = mysqli_fetch_assoc($query);

            if(password_verify($pass, $user['password'])){
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $uesr['name'];
                
                header("Location: dashboard.php");
                exit();
            }else{
                header("Location: index.html?status=invalid_pass");
                exit();
            }
        }else{
            header("Location: index.html?status=email_not_found");
            exit();
        }
    }else{
        echo "Error executing query :  ". mysqli_error($connect);
    }
}

?>