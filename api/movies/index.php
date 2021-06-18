<?php

header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Origin: http://bsi.video.test");
header("Access-Control-Allow-Credentials: true");

session_start();

if (!isset($_SESSION['userId'])) {
    echo json_encode(array('message'=>'Acesso negado'));
    return http_response_code(403);
    exit;
}


require_once '../database/index.php';
require_once './movies.class.php';

$movies = new Movies();

$method = $_SERVER['REQUEST_METHOD'];
$url = $_SERVER['REQUEST_URI'];

$url_components = parse_url($url); 

if(empty($url_components['query'])) {
    $params = "";
} else {
    parse_str($url_components['query'], $params);
}

if(!empty($_SERVER['PATH_INFO'])) {
    $request = explode("/", $_SERVER['PATH_INFO']);
} else {
    $request = "";
}

switch ($method) {
    case 'PATCH':
        $movies->update($mysqli);  
        break;
    case 'POST':
        $movies->create($mysqli);  
        break;
    case 'GET':
        $movies->find($mysqli, $request, $params); 
        break;
    case 'DELETE':
        $movies->delete($mysqli, $request); 
        break;
    default:
        handle_error($request);  
        break;
}