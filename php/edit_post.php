<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include("config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST'&& isset($_POST['post_content_clone'])) {
    $user_id = $_SESSION['id'];
    $post_id = $_SESSION['post_id'];
    $post_content = $_POST['post_content_clone'];

    echo $user_id;
    echo $post_id;
    echo $post_content;

    $img_url = null;
    if ($_FILES['post_image_clone']['size'] > 0) {
        $img_name = $_FILES['post_image_clone']['name'];
        $img_tmp = $_FILES['post_image_clone']['tmp_name'];
        $img_url = "C:/xampp/htdocs/social/uploads/" . $img_name;
        move_uploaded_file($img_tmp, $img_url);
        $img_url = "./uploads/" . $img_name;
    }
    $query = mysqli_query($con, "UPDATE posts SET description='$post_content', img='$img_url' WHERE id=$post_id") or die("Error Occurred");
    mysqli_query($con, $query);

    header("Location: ../home.php");
    exit();
}