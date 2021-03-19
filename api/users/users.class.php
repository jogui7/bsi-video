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
        printf("Errormessage: %s\n", $mysqli->error);

        $mysqli->close();

        exit;
    }

    public function find($mysqli, $request){
        $query = "SELECT * FROM users";

        $result = $mysqli->query($query);
        //printf("Errormessage: %s\n", $mysqli->error);

        $users = mysqli_fetch_all($result, MYSQLI_ASSOC);

        echo json_encode($users[0]);

        $mysqli->close();

        exit;
    }

    public function update($request){

    }

    public function delete($request){

    }
}