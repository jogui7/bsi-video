<?php 

class Movies {

    public function find($mysqli, $request){
        if(isset($request[1]) && $request[1] != "") {
            $id = $request[1];
            $query = "SELECT * FROM movies WHERE id = '{$id}'";
        } else {
            $query = "SELECT * FROM movies";
        }

        $result = $mysqli->query($query);
        $mysqli->close();

        $movies = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(sizeof($movies) == 1){
            $movies = $movies[0];
        }

        echo json_encode($movies);
        return http_response_code(200);

    }

}

?>