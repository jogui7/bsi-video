<?php

require_once '../database/index.php';
require_once './users.class.php';

$users = new Users();

$method = $_SERVER['REQUEST_METHOD'];
$request = $_SERVER['QUERY_STRING'];


switch ($method) {
    case 'PATCH':
        $users->update($request);  
        break;
    case 'POST':
        $users->create($mysqli);  
        break;
    case 'GET':
        $users->find($mysqli, $request); 
        break;
    case 'DELETE':
        $users->delete($request); 
        break;
    default:
        handle_error($request);  
        break;
}