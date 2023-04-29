<?php

spl_autoload_register(function ($class) {
    require_once lcfirst(str_replace('\\', '/', $class)) . '.php';
});

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");


//ROUTER
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // This is a preflight request
    header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    exit;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $content = file_get_contents("php://input");
    $data = json_decode($content, true);

    $user_id = $data['user_id'];
    $comp = $data['comp'];
    $comp_desc = $data['comp_desc'];

    $DDB = new Models\Database();
    $result = $DDB->postComp($user_id, $comp, $comp_desc);

    $json = json_encode('Database has been updated');
    echo ($json);
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $controller = new Models\Database();
    $result = $controller->getAllComp($_GET['user']);

    $json = json_encode($result);
    echo ($json);
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    $json = json_encode('put<br>');
    echo ($json);
} else {

    $json = json_encode('else<br>');
    echo ($json);
}
