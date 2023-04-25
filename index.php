<?php

session_start();


spl_autoload_register(function ($class) {
    require_once lcfirst(str_replace('\\', '/', $class)) . '.php';
});



//Router
if (array_key_exists('route', $_GET)) {

    switch ($_GET['route']) {

        case 'dashboard':
            $controller = new Models\Articles();
            $result = $controller->getAllArticles();
            echo $result;
            break;

        default:
            header('Location: index.php?route=dashboard');
            exit;
            break;
    }
} else {
    header('Location: index.php?route=dashboard');
    exit;
}
