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

    switch ($_GET['route']) {

        case 'event':
            $authController = new Controllers\AuthorisationController();
            $decoded = $authController->authenticate(); // Authenticate the user before processing the request

            $userId = $decoded->userId->id;

            $controller = new Controllers\EventsController();
            $controller->postNewEvent($userId);
            break;

        case 'graph':
            $authController = new Controllers\AuthorisationController();
            $decoded = $authController->authenticate(); // Authenticate the user before processing the request

            $userId = $decoded->userId->id;

            $controller = new Controllers\GraphsController();
            $controller->createNewGraph($userId);
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

            $authController = new Controllers\AuthorisationController();
            $decoded = $authController->authenticate(); // Authenticate the user before processing the request

            $userId = $decoded->userId->id;

            $controller = new Models\Database();
            $result = $controller->getAllGraphsFromUser($userId);
            $json = json_encode($result);
            echo ($json);
            break;

        case 'graph':
            $authController = new Controllers\AuthorisationController();
            $decoded = $authController->authenticate(); // Authenticate the user before processing the request

            $userId = $decoded->userId->id;
            //$json = json_encode($userId);
            //echo ($json);
            //break;

            $controller = new Models\Database();
            $result = $controller->getAllEventsFromGraph($userId, $_GET['graphId']);
            $json = json_encode($result);
            echo ($json);
            break;
    }
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
