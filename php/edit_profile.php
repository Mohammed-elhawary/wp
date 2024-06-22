<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_content = $_POST['post_content'] ?? '';
    $age = $_POST['age'] ?? '';
    $city = $_POST['city'] ?? '';
    $password = $_POST['password'] ?? '';
    $repassword = $_POST['repassword'] ?? '';
    $email = $_POST['email'] ?? '';
    $name = $_POST['name'] ?? '';
    $user_id = $_SESSION['id'] ?? '';
    $img = $_POST['img'] ?? '';
    $imgback = $_POST['imgback'] ?? '';
    

    if ($password != $repassword) {
        $message = "Passwrods not matching!";

        echo $message;
        exit(); 
    }
    if (strlen($password) < 8) {
        $message = "Passwrod needs to be at least 8 characters!";
        echo $message;
        exit();
    }

    if (!empty($name)) {
        $query = mysqli_query($con, "UPDATE users SET username='$name', email='$email', password='$password', age='$age', city='$city', description='$post_content', profilepic='$img', coverpic='$imgback' WHERE id=$user_id") or die("Error Occurred");
        $message = "success!";
        echo $message; 
    }
} else {
    echo 'Error: postId, action, or user_id is missing.';
}
