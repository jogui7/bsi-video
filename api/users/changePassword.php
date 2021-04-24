<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: PATCH");
    require_once '../database/index.php';

    $body = json_decode(file_get_contents('php://input', true));

    $query = "UPDATE users SET password = '{$body->password}', token = null WHERE token = '{$body->token}'";        

    $result = $mysqli->query($query);

    if (!$result) {
        echo json_encode(array('message'=>'Erro ao alterar senha!'));
        return http_response_code(400);
        exit;
    }

    echo json_encode(array('message'=>'Senha alterada com sucesso!'));
    return http_response_code(200);
    
    exit;
?>