<?php 

class Favorites {

    public function find($mysqli){
        $id = $_SESSION["userId"];

        $query = "SELECT movie_id FROM favorites WHERE user_id = '{$id}'";

        $result = $mysqli->query($query);

        $favoritesIds = mysqli_fetch_row($result);

        if(mysqli_num_rows($result) == 0) {
            $mysqli->close();
            echo json_encode(array('message' => 'Nenhum filme favoritado!'));
            return http_response_code(404);
        }
        
        $query = "SELECT * FROM movies WHERE id IN (". implode(',', array_map('intval', $favoritesIds)) . ")";

        $result = $mysqli->query($query);

        $movies = mysqli_fetch_all($result, MYSQLI_ASSOC);

        echo json_encode($movies);
        return http_response_code(200);
    }

    public function create($mysqli){

        $id = $_SESSION["userId"];

        $body = json_decode(file_get_contents('php://input', true));

        $query = "SELECT * FROM favorites WHERE user_id = '{$id}' AND movie_id = '{$body->movieId}'";

        $result = $mysqli->query($query);

        if(mysqli_num_rows($result) > 0) {
            echo json_encode(array('message' => 'Filme já favoritado!'));
            return http_response_code(400);
        }

        $query = "INSERT INTO favorites VALUES ('','{$id}', '{$body->movieId}')";        

        if(!$mysqli->query($query)) {
            echo json_encode(array('message' => 'Erro ao favoritar'));
            return http_response_code(400);
        }

        $mysqli->close();

        echo json_encode(array('message' => 'Filme adicionado aos favoritos!'));
        return http_response_code(200);
    }

    public function delete($mysqli){

        $id = $_SESSION["userId"];

        $body = json_decode(file_get_contents('php://input', true));

        $query = "DELETE FROM favorites WHERE user_id = '{$id}' AND movie_id = '{$body->movieId}'";   

        $mysqli->query($query);

        if($mysqli->affected_rows < 1) {
            $mysqli->close();
            echo json_encode(array('message' => 'Erro ao remover favorito'));
            return http_response_code(400);
        }

        $mysqli->close();

        return http_response_code(200);
    }

}

?>