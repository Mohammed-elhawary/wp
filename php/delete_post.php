<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_POST['postId'] ?? '';
    $user_id = $_SESSION['id'] ?? '';
    if (!empty($post_id) && !empty($user_id)) {
            mysqli_query($con, "DELETE FROM posts WHERE id = $post_id");
            echo"success!";
    } 
    
}
