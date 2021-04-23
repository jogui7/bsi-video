<?php 

require_once '../mailer/email.class.php';

class Users {

    public function create($mysqli){
        $body = json_decode(file_get_contents('php://input', true));

        $query = "SELECT * FROM users WHERE email = '{$body->email}'";

        $result = $mysqli->query($query);

        if(mysqli_num_rows($result) > 0) {
            echo json_encode(array('message' => 'Email já está em uso!'));
            return http_response_code(400);
        }

        $token = uniqid("");

        $query = "INSERT INTO users VALUES ('','{$body->name}', '{$body->birthdate}', '{$body->email}', '{$body->password}', '{$body->creditCardNumber}', '{$body->creditCardExpireDate}', '{$body->ccv}', '{$body->cardHolderName}', '{$body->cpfCNPJ}', 'false','{$token}')";        

        if(!$mysqli->query($query)) {
            echo json_encode(array('message' => 'Erro ao cadastrar usuário!'));
            return http_response_code(400);
        }

        $email = new Email();
        $title = 'Confirme o seu cadastro na bsivideo';
		$message = 'Confirme seu email clicando no link a seguir: '.'<a href="bsi.video.test/api/confirmUser/?token='.$token.'">confirmar cadastro</a>';

        $email->send($title, $message, $body->email);

        $mysqli->close();

        echo json_encode(array('message' => 'Usuário cadastrado com sucesso!'));
        return http_response_code(200);

        exit;
    }

    public function find($mysqli, $request){
        if($request[1]) {
            $id = $request[1];
            $query = "SELECT * FROM users WHERE id = '{$id}'";
        } else {
            $query = "SELECT * FROM users";
        }

        $result = $mysqli->query($query);
        $mysqli->close();

        $users = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(sizeof($users) == 1){
            $users = $users[0];
        }

        echo json_encode($users);
        return http_response_code(200);

    }

    public function update($request){

    }

    public function delete($mysqli, $request){
        if($request[1]) {
            $id = $request[1];
            $query = "DELETE FROM users WHERE id = '{$id}'";
        } else {
            echo json_encode(array('message' => 'Usuário não encontrado!'));
            return http_response_code(400);
        }

        $result = $mysqli->query($query);
        $mysqli->close();

        if(!$result) {
            echo json_encode(array('message' => 'Usuário não encontrado!'));
            return http_response_code(400);
        }

        echo json_encode(array('message' => 'Usuário removido com sucesso!'));
        return http_response_code(200);
    }
}