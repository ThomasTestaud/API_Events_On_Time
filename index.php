<?php

session_start();


spl_autoload_register(function ($class) {
    require_once lcfirst(str_replace('\\', '/', $class)) . '.php';
});

//Router
if (array_key_exists('route', $_GET)) {

    switch ($_GET['route']) {

        case 'api':
            $controller = new Models\Database();
            $result = $controller->getAllComp(0);
            $json = json_encode($result);
            header('Content-Type: application/json');
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
