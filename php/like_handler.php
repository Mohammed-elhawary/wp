<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include("config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_POST['postId'] ?? '';
    $action = $_POST['action'] ?? '';
    $user_id = $_SESSION['id'] ?? '';

    if (!empty($post_id) && !empty($action) && !empty($user_id)) {
        $check_query = mysqli_query($con, "SELECT * FROM likes WHERE userid = $user_id AND postid = $post_id");
        if ($check_query) {
            $ratingstatus = mysqli_num_rows($check_query);
            if ($ratingstatus > 0) {
                if ($action == 'like') {
                    mysqli_query($con, "UPDATE likes SET rating = 'like' WHERE userid = $user_id AND postid = $post_id");
                    echo 'liked';
                } elseif ($action == 'unlike') {
                    mysqli_query($con, "UPDATE likes SET rating = '' WHERE userid = $user_id AND postid = $post_id");
                    echo 'unliked';
                }
            } else {
                mysqli_query($con, "INSERT INTO likes (userid, postid, rating) VALUES ($user_id, $post_id, 'like')");
                echo 'liked';
            }
        } else {
            echo 'Error executing the query.';
        }
    } else {
        echo 'Error: postId, action, or user_id is missing.';
    }
}
