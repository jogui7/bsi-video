<?php
    require_once '../database/index.php';
    $token = $_GET['token'];

    $query = "UPDATE users SET is_confirmed = true, token = null WHERE token = '{$token}'";        

    $result = $mysqli->query($query);

    if (!$result) {
        return http_response_code(400);
        exit;
    }

    header("Location: http://bsi.video.test");
    
    exit;
?>