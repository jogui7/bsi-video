<?php 

class Auth {

    public function create($mysqli){
        $body = json_decode(file_get_contents('php://input', true));

        $query = "SELECT * FROM users WHERE email = '{$body->email}' AND password = '{$body->password}'";

        $result = $mysqli->query($query);

        if(mysqli_num_rows($result) > 0) {
            echo json_encode(array('message' => 'Logado com sucesso!'));

            $user = mysqli_fetch_row($result);

            $this->startSession($user);

            return http_response_code(200);
        }

        $mysqli->close();

        echo json_encode(array('message' => 'Usuário ou senha incorretos!'));
        return http_response_code(401);

    }

    public function getSession(){
        session_set_cookie_params(['SameSite' => 'None']);
        session_start();
        if (!isset($_SESSION['userId'])) {
            echo json_encode(array('message'=>'Usuário não logado'));
            return http_response_code(403);
            exit;
        }

        echo json_encode($_SESSION);
        return http_response_code(200);
    }

    public function delete() {
        session_start();

        session_destroy();

        return http_response_code(200);
    }

    private function startSession($user) {
        session_set_cookie_params(['SameSite' => 'None']);
        session_start();
        $_SESSION["userId"] = $user[0];
        $_SESSION["userName"] = $user[1];
        $_SESSION["userBirthDate"] = $user[2];
        $_SESSION["userEmail"] = $user[3];
        $_SESSION["userCardNumber"] = $user[5];
        $_SESSION["userCardExpireDate"] = $user[6];
        $_SESSION["userCCV"] = $user[7];
        $_SESSION["userCardHolderName"] = $user[8];
        $_SESSION["userCpf"] = $user[9];
    }

}