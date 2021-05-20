<?php 

class Favorites {

    public function getMovieIds($v) {
        return $v;
    }

    public function find($mysqli) {
        $id = $_SESSION["userId"];

        $query = "SELECT movie_id FROM favorites WHERE user_id = '{$id}'";

        $result = $mysqli->query($query);

        $favoritesIds = [];

        if(mysqli_num_rows($result) < 1) {
            $mysqli->close();
            echo json_encode([]);
            return http_response_code(200);
        }

        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($rows as $row) {
            array_push($favoritesIds, $row["movie_id"]);
        }


        $query = "SELECT * FROM movies WHERE id IN (". implode(',', $favoritesIds) . ")";

        $result = $mysqli->query($query);

        $movies = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $mysqli->close();

        echo json_encode($movies);
        return http_response_code(200);
    }

    public function create($mysqli, $request) {

        $id = $_SESSION["userId"];
        $movieId = $request[1];

        $query = "SELECT * FROM favorites WHERE user_id = '{$id}' AND movie_id = '{$movieId}'";

        $result = $mysqli->query($query);

        if(mysqli_num_rows($result) > 0) {
            echo json_encode(array('message' => 'Filme já favoritado!'));
            return http_response_code(400);
        }

        $query = "INSERT INTO favorites VALUES ('','{$id}', '{$movieId}')";        

        if(!$mysqli->query($query)) {
            echo json_encode(array('message' => 'Erro ao favoritar'));
            return http_response_code(400);
        }

        $mysqli->close();

        echo json_encode(array('message' => 'Filme adicionado aos favoritos!'));
        return http_response_code(200);
    }

    public function delete($mysqli, $request) {

        $id = $_SESSION["userId"];
        $movieId = $request[1];

        $query = "DELETE FROM favorites WHERE user_id = '{$id}' AND movie_id = '{$movieId}'";   

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