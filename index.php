<?php

spl_autoload_register(function ($class) {
    require_once lcfirst(str_replace('\\', '/', $class)) . '.php';
});


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo 'post<br>';
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //echo 'get<br>';
    $controller = new Models\Database();
    $result = $controller->getAllComp($_GET['user']);
    $json = json_encode($result);
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    echo ($json);
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    echo 'put<br>';
} else {
    echo 'else<br>';
}



/*
//Router
if (array_key_exists('route', $_GET)) {

    switch ($_GET['route']) {

        case 'api':
            $controller = new Models\Database();
            $result = $controller->getAllComp($_GET['user']);
            $json = json_encode($result);
            header('Content-Type: application/json');
            header("Access-Control-Allow-Origin: *");
            echo ($json);
            break;

        default:
            header('Location: index.php?route=api');
            exit;
            break;
    }
} else {
    header('Location: index.php?route=api');
    exit;
}
*/