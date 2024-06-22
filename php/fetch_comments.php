<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include("config.php");

if (isset($_POST['postId'])) {
    $postId = $_POST['postId'];
    $commentsQuery = "SELECT * FROM comments WHERE postid = $postId";

    $commentsResult = mysqli_query($con, $commentsQuery);

    if ($commentsResult && mysqli_num_rows($commentsResult) > 0) {
        $comments = array();
        $commentids = array();
        $commentownerid = array();
        while ($comment = mysqli_fetch_assoc($commentsResult)) {
            $comments[] = $comment['descerption'];
            $commentids[] = $comment['id'];
            $commentownerid[] = $comment['userid'];
        }
        $response = array(
            'comments' => $comments,
            'commentIds' => $commentids,
            'commentownerid' => $commentownerid
        );
        echo json_encode($response); 
    } else {
        echo json_encode(array('message' => 'No comments available.'));
    }
} else {
    echo json_encode(array('message' => 'Invalid request.'));
}
