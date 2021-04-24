<?php

session_start();

if (!isset($_SESSION['userId'])) {
    echo json_encode(array('message'=>'Acesso negado'));
    return http_response_code(403);
    exit;
}

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");

require_once '../database/index.php';
require_once './movies.class.php';

$movies = new Movies();

$method = $_SERVER['REQUEST_METHOD'];
// $request = $_SERVER['QUERY_STRING'];

if(isset($_SERVER['PATH_INFO'])) {
    $request = explode("/", $_SERVER['PATH_INFO']);
}

$request = "";

switch ($method) {
    case 'PATCH':
        $movies->update($mysqli);  
        break;
    case 'POST':
        $movies->create($mysqli);  
        break;
    case 'GET':
        $movies->find($mysqli, $request); 
        break;
    case 'DELETE':
        $movies->delete($mysqli, $request); 
        break;
    default:
        handle_error($request);  
        break;
}