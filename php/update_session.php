<?php
session_start();

if (!isset($_SESSION['post_id'])) {
    $_SESSION['post_id'] = "";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['post_id'] = $_POST['id'];
    
    echo $_SESSION['post_id'];
    
    echo json_encode(['message' => 'Session updated']);
} else {
    echo json_encode(['error' => 'Invalid request']);
}
