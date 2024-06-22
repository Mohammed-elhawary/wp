<?php
session_start();

include("config.php");
if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $result = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND Password='$password' ") or die("Select Error");
    $row = mysqli_fetch_assoc($result);

    if (is_array($row) && !empty($row)) {
        $_SESSION['valid'] = $row['email'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['id'] = $row['id'];
    } else {
        $message = "Wrong Username or Password";
        echo "<script>alert('" . htmlspecialchars($message, ENT_QUOTES) . "');window.location.href='../index.php';</script>";
        exit(); 
    }
    if (isset($_SESSION['valid'])) {
        header("Location: ../home.php");
    }
}

