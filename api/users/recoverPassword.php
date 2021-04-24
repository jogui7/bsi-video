<?php
    header("Access-Control-Allow-Origin: *");
    require_once '../mailer/email.class.php';
    require_once '../database/index.php';

    $body = json_decode(file_get_contents('php://input', true));

    $token = uniqid("");

    $query = "UPDATE users SET token = '{$token}' WHERE email = '{$body->email}'";        

    $result = $mysqli->query($query);

    if (!$result) {
        echo json_encode(array('message'=>'Erro ao enviar email de recuperação de senha!'));
        return http_response_code(400);
        exit;
    }

    $email = new Email();
    $title = 'Recuperação de senha bsivideo';
	$message = 'Altere sua senha no link a seguir: '.'<a href="bsi.video.test/alterarSenha.html?token='.$token.'">recuperar senha</a>';

    $email->send($title, $message, $body->email);

    echo json_encode(array('message'=>'Email de recuperação de senha enviado com sucesso!'));
    return http_response_code(200);
    
    exit;
?>