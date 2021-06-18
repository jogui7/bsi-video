<?php 

class Movies {

    public function find($mysqli, $request, $params){
        if(isset($request[1]) && $request[1] != "") {
            $id = $request[1];
            $query = "SELECT * FROM movies WHERE id = '{$id}'";
        } else {
            $query = "SELECT * FROM movies";
        }
        
        if($params != "") {
            $filter = [];

            if(isset($params['title'])) {
                array_push($filter, "title LIKE '%".$params['title']."%'");
            }

            if(isset($params['releaseDate'])) {
                array_push($filter, "Year(release_date) = '".$params['releaseDate']."'");
            }

            if(isset($params['genre'])) {
                array_push($filter, "genre = '".$params['genre']."'");
            }

            if(isset($params['relevance'])) {
                array_push($filter, "relevance >= '".$params['relevance']."'");
            }

            if(isset($params['isMovie'])) {
                array_push($filter, "is_movie = '".$params['isMovie']."'");
            }

            if(count($filter) > 0){
                $filter = implode(" AND ", $filter);
                $query = $query." WHERE ".$filter;
            }
        }
        
        $result = $mysqli->query($query);
        $mysqli->close();

        $movies = mysqli_fetch_all($result, MYSQLI_ASSOC);

        echo json_encode($movies);
        return http_response_code(200);

    }

    public function create($mysqli){

        $title = $_POST['title'];
        $genre = $_POST['genre'];
        $release_date = $_POST['release_date'];
        $relevance = $_POST['relevance'];
        $synopsis = $_POST['synopsis'];
        $trailer = $_POST['trailer'];
        $duration = $_POST['duration'];
        $banner = $_FILES["banner"];
        $is_movie = $_POST['is_movie'];

		$imagem_temp = imagecreatefromjpeg($banner["tmp_name"]);

        imagejpeg($imagem_temp, "../img/".$banner["name"]);

        $banner_url = "http://bsi.video.test/api/img/".$banner["name"];

        $query = "INSERT INTO movies VALUES ('','{$title}', '{$genre}', '{$release_date}', '{$relevance}', '{$synopsis}', '{$trailer}', '{$duration}', '{$banner_url}', '{$is_movie}')";        

        if(!$mysqli->query($query)) {
            echo json_encode(array('message' => 'Erro ao cadastrar filme!'));
            return http_response_code(400);
        }

        $mysqli->close();

        echo json_encode(array('message' => 'Filme cadastrado com sucesso!'));
        return http_response_code(200);

        exit;
    }

}

?>