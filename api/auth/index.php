<?php
header("Access-Control-Allow-Methods: PATCH, POST, GET, DELETE");
header("Access-Control-Allow-Origin: http://bsi.video.test");
header("Access-Control-Allow-Credentials: true");
require_once '../database/index.php';
require_once './auth.class.php';

$auth = new Auth();

$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", $_SERVER['PATH_INFO']);


switch ($method) {
    case 'POST':
        $auth->create($mysqli);  
        break;
    case 'GET':
        $auth->getSession();  
        break;
    case 'DELETE':
        $auth->delete();  
        break;
    default:
        handle_error($request);  
        break;
}