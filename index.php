<?php

session_start();


spl_autoload_register(function ($class) {
    require_once lcfirst(str_replace('\\', '/', $class)) . '.php';
});



//Router
if (array_key_exists('route', $_GET)) {

    switch ($_GET['route']) {

        case 'api':
            $controller = new Models\Articles();
            $result = $controller->getAllArticles();
            var_dump($result);
            foreach ($result as $res) {
                echo $res;
            }
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
