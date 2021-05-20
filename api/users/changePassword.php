<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: PATCH");
    header("Access-Control-Allow-Origin: http://bsi.video.test");
    header("Access-Control-Allow-Credentials: true");
    require_once '../database/index.php';

    $body = json_decode(file_get_contents('php://input', true));

    $query = "UPDATE users SET password = '{$body->password}', token = null WHERE token = '{$body->token}'";        

    $mysqli->query($query);


    $method = $_SERVER['REQUEST_METHOD'];

    if ($mysqli->affected_rows < 1 && $method == 'PATCH') {
        echo json_encode(array('message'=>'Erro ao alterar senha!'));
        return http_response_code(400);
        exit;
    }

    echo json_encode(array('message'=>'Senha alterada com sucesso!'));
    return http_response_code(200);
    
    exit;
?>