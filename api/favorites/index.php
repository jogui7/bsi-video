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
require_once './favorites.class.php';

$favorites = new Favorites();

$method = $_SERVER['REQUEST_METHOD'];
// $request = $_SERVER['QUERY_STRING'];

if(isset($_SERVER['PATH_INFO'])) {
    $request = explode("/", $_SERVER['PATH_INFO']);
}

$request = "";

switch ($method) {
    case 'PATCH':
        $favorites->update($mysqli);  
        break;
    case 'POST':
        $favorites->create($mysqli);  
        break;
    case 'GET':
        $favorites->find($mysqli); 
        break;
    case 'DELETE':
        $favorites->delete($mysqli); 
        break;
    default:
        handle_error($request);  
        break;
}