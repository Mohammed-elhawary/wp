<?php

include("config.php");

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];

    if($password !=$repassword){
        $message = "Passwrods not matching!";
        echo "<script>alert('" . htmlspecialchars($message, ENT_QUOTES) . "');window.location.href='../register.php';</script>";
        exit(); 
    }
    if(strlen($password)< 8)
    {
        $message = "Passwrod needs to be at least 8 characters!";
        echo "<script>alert('" . htmlspecialchars($message, ENT_QUOTES) . "');window.location.href='../register.php';</script>";
        exit(); 
    }

    $verify_query = mysqli_query($con, "SELECT email FROM users WHERE email='$email'");

    if (mysqli_num_rows($verify_query) != 0) {
        $message = "This email is used, Try another one please!";
        echo "<script>alert('" . htmlspecialchars($message, ENT_QUOTES) . "');window.location.href='../register.php';</script>";
        exit(); 
    }
    else {
        mysqli_query($con, "INSERT INTO users(Username,Email,Password,profilepic) VALUES('$username','$email','$password', './img/user.png')") or die("Error Occurred");
        $message = "Registration successful!";
        echo "<script>alert('" . htmlspecialchars($message, ENT_QUOTES) . "');window.location.href='../index.php';</script>";
        exit(); 
    }
}
