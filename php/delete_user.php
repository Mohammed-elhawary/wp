<?php
session_start();

include("config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username'])) {
        $username = mysqli_real_escape_string($con, $_POST['username']);
        $deleteQuery = "DELETE FROM users WHERE username = '$username'";
        $result = mysqli_query($con, $deleteQuery);
        if ($result) {
            echo json_encode(array('message' => 'User deleted successfully.'));
        } else {
            echo json_encode(array('message' => 'Error deleting user.' ));
            
        }
    } else {
        echo json_encode(array('message' => 'Username not provided.'));
    }
} else {
    echo json_encode(array('message' => 'Invalid request method.'));
}

