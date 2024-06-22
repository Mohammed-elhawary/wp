<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include("config.php");

if (isset($_POST['post_content'])) {
    $post_content = $_POST['post_content'];
    $user_id = $_SESSION['id'];

    $img_url = null;
    if ($_FILES['post_image']['size'] > 0) {
        $img_name = $_FILES['post_image']['name'];
        $img_tmp = $_FILES['post_image']['tmp_name'];
        $img_url = "C:/xampp/htdocs/social/uploads/" . $img_name;
        move_uploaded_file($img_tmp, $img_url);
        $img_url = "./uploads/" . $img_name;
    }

    $insert_query = "INSERT INTO posts (description, img, userid, createdAt) VALUES (?, ?, ?, NOW())";
    $stmt = mysqli_prepare($con, $insert_query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssi", $post_content, $img_url, $user_id);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);

        header("Location: ../home.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
