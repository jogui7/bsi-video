<?php 

class Users {

    public function create($mysqli){
        $body = json_decode(file_get_contents('php://input', true));

        $options = [
            'cost' => 11
        ];

        $password = password_hash($body->password, PASSWORD_BCRYPT, $options);

        $query = "INSERT INTO users VALUES ('','{$body->name}', '{$body->birthdate}', '{$body->email}', '{$password}', '{$body->creditCardNumber}', '{$body->creditCardExpireDate}', '{$body->ccv}', '{$body->cardHolderName}', '{$body->cpfCNPJ}')";

        
        $result = $mysqli->query($query);

        $mysqli->close();

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
        // printf("Errormessage: %s\n", $mysqli->error);

        $users = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(sizeof($users) == 1){
            $users = $users[0];
        }
        
        echo json_encode($users);

        $mysqli->close();

        exit;
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

        $mysqli->query($query);
        $mysqli->close();

        echo json_encode(array('message' => 'Usuário removido com sucesso!'));
        return http_response_code(200);
    }
}