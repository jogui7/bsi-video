<?php 

class Auth {

    public function create($mysqli){
        $body = json_decode(file_get_contents('php://input', true));

        $query = "SELECT * FROM users WHERE email = '{$body->email}' AND password = '{$body->password}'";

        $result = $mysqli->query($query);

        if(mysqli_num_rows($result) > 0) {
            echo json_encode(array('message' => 'Logado com sucesso!'));
            return http_response_code(200);
        }

        $mysqli->close();

        echo json_encode(array('message' => 'Usuário ou senha incorretos!'));
        return http_response_code(401);

    }
}