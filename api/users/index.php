<?php

header("Access-Control-Allow-Methods: PATCH, POST, GET, DELETE");
header("Access-Control-Allow-Origin: http://bsi.video.test");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type,If-Modified-Since,Cache-Control");

session_set_cookie_params(['SameSite' => 'None']);
session_start();

require_once '../database/index.php';
require_once './users.class.php';

$users = new Users();

$method = $_SERVER['REQUEST_METHOD'];
// $request = $_SERVER['QUERY_STRING'];

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