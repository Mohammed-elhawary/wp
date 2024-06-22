<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include("config.php");

if (isset($_POST['post_content'])) {
    $post_content = $_POST['post_content'];
    $user_id = $_SESSION['id'];
    $post_id = $_POST['post_id'];

    $insert_query = "INSERT INTO comments (descerption, createdAt, userid, postid) VALUES ('$post_content',  NOW(), $user_id, $post_id)";
    mysqli_query($con, $insert_query);

    header("Location: ../home.php");
    exit();
}