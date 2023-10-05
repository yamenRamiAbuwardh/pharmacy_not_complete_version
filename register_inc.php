<?php

if (isset($_POST['submit'])) {
   //echo "Clicked";

    require "conn.php";

    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];


    //Error handles
    if (empty($username) || empty($password) || empty($confirm_password) || empty($role)) {
       header("Location:index.php?error=emptyfields&username=".$username);
       exit();

       //check for invalid fields
       
    }elseif (!preg_match("/^[a-zA-Z0-9]*/", $username)) {
        header("Location:ister.php?error=invalidfields&username".$username);
        exit();
        //check if the password match
    }elseif ($password !== $confirm_password) {
        header("Location:ister.php?error=passworddonotmatch&username".$usename);
        exit();   
        //check if the username i taken or not
    }else {
        $sql = "SELECT username FROM users WHERE username = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
           header("Location:index.php?error=sqlerror");
           exit();
        }else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $rowCount = mysqli_stmt_num_rows($stmt);
            if ($rowCount > 0) {
                header("Location:index.php?error=usernametaken&username".$username);
                exit();
                // insert data into the database
            }else {
                $sql = " INSERT INTO users (username,role, password) values (?,?,?)";
                $stmt = mysqli_stmt_init($conn);
               if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location:index.php error=sqlerror");
                exit();
                //create a hashed password
               }else {
                //    $hashedPass = password_hash($password, PASSWORD_DEFAULT);
                   mysqli_stmt_bind_param($stmt, "sss" , $role,$username, $password);
                   mysqli_stmt_execute($stmt);
                    header("Location:index.php?succes=registered");
               }
            }
        }

    }
    
}

?>