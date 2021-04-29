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
		$message = 'Confirme seu email clicando no link a seguir: '.'<a href="bsi.video.test/api/users/confirmUser?token='.$token.'">confirmar cadastro</a>';

        $email->send($title, $message, $body->email);

        $mysqli->close();

        echo json_encode(array('message' => 'Usuário cadastrado com sucesso!'));
        return http_response_code(200);

        exit;
    }

    public function find($mysqli, $request){
        if(isset($request[1])) {
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

    public function update($mysqli){
        
        $id = $_SESSION["userId"];

        $body = json_decode(file_get_contents('php://input', true));

        $query = [];

        if(isset($body->name)) {
            array_push($query, "name = '{$body->name}'");
            $_SESSION["userName"] = $body->name;
        }

        if(isset($body->birthDate)) {
            array_push($query, "birthdate = '{$body->birthDate}'");
            $_SESSION["userBirthDate"] = $body->birthDate;
        }

        if(isset($body->email)) {
            array_push($query, "email = '{$body->email}'");
            $_SESSION["userEmail"] = $body->email;
        }

        if(isset($body->creditCardNumber)) {
            array_push($query, "credit_card_number = '{$body->creditCardNumber}'");
            $_SESSION["userCardNumber"] = $body->creditCardNumber;
        }

        if(isset($body->creditCardExpireDate)) {
            array_push($query, "credit_card_expire_date = '{$body->creditCardExpireDate}'");
            $_SESSION["userCardExpireDate"] = $body->creditCardExpireDate;
        }

        if(isset($body->ccv)) {
            array_push($query, "ccv = '{$body->ccv}'");
            $_SESSION["userCCV"] = $body->ccv;
        }

        if(isset($body->cardHolderName)) {
            array_push($query, "card_holder_name = '{$body->cardHolderName}'");
            $_SESSION["userCardHolderName"] = $body->cardHolderName;
        }

        if(isset($body->cpfCnpj)) {
            array_push($query, "cpf_cnpj = '{$body->cpfCnpj}'");
            $_SESSION["userCpf"] = $body->cpfCnpj;
        }

        $query = implode(", ", $query);

        $query = "UPDATE users SET ".$query." WHERE id = '{$id}'";

        $mysqli->query($query);

        if($mysqli->affected_rows < 1) {
            echo json_encode(array('message' => 'Usuário não encontrado!'));
            return http_response_code(400);
        }

        $mysqli->close();

        echo json_encode(array('message' => 'Usuário alterado com sucesso!'));
        return http_response_code(200);
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