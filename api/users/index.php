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
require_once './users.class.php';

$users = new Users();

$method = $_SERVER['REQUEST_METHOD'];
// $request = $_SERVER['QUERY_STRING'];
if(isset($_SERVER['PATH_INFO'])) {
    $request = explode("/", $_SERVER['PATH_INFO']);
}

$request = "";

switch ($method) {
    case 'PATCH':
        $users->update($mysqli);  
        break;
    case 'POST':
        $users->create($mysqli);  
        break;
    case 'GET':
        $users->find($mysqli, $request); 
        break;
    case 'DELETE':
        $users->delete($mysqli, $request); 
        break;
    default:
        handle_error($request);  
        break;
}