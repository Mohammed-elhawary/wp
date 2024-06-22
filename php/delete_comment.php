<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include ("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comment_id = $_POST['commentid'] ?? '';
    mysqli_query($con, "DELETE FROM comments WHERE id = $comment_id");
    echo json_encode(array('message' => 'success!'));
}
