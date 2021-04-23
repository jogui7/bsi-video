<?php
header("Access-Control-Allow-Origin: *");

require_once '../database/index.php';
require_once './auth.class.php';

$auth = new Auth();

$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", $_SERVER['PATH_INFO']);


switch ($method) {
    case 'POST':
        $auth->create($mysqli);  
        break;
    default:
        handle_error($request);  
        break;
}