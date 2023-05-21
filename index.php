<?php

spl_autoload_register(function ($class) {
    require_once lcfirst(str_replace('\\', '/', $class)) . '.php';
});

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");



//VERIFY USER





//ROUTER
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // This is a preflight request
    header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    exit;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

    switch ($_GET['route']) {

        case 'event':
            $controller = new Controllers\EventsController();
            $controller->postNewEvent();
            break;

        case 'graph':
            $controller = new Controllers\GraphsController();
            $controller->createNewGraph();
            break;

        case 'connect':
            $controller = new Controllers\UsersController();
            $controller->connectUser();
            break;

        case 'user':
            $controller = new Controllers\UsersController();
            $controller->createUser();
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {

    switch ($_GET['route']) {

        case 'list':
            $controller = new Models\Database();
            $result = $controller->getAllGraphsFromUser($_GET['userId']);
            break;

        case 'graph':
            $controller = new Models\Database();
            $result = $controller->getAllEventsFromGraph($_GET['graphId']);
            break;
    }
    $json = json_encode($result);
    echo ($json);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

    switch ($_GET['route']) {

        case 'event':
            $controller = new Controllers\EventsController();
            $controller->deleteLastEvent();
            break;

        case 'graph':
            $controller = new Controllers\GraphsController();
            $controller->deleteGraph();
            break;
    }
} else {

    $json = json_encode('else   ');
    echo ($json);
}
