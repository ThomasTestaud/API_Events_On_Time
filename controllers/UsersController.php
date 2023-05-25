<?php

namespace Controllers;

class UsersController
{

    public function connectUser()
    {
        $content = file_get_contents("php://input");
        $data = json_decode($content, true);

        $userName = $data['userName'];
        $userPassword = $data['userPassword'];

        $model = new \Models\Database();
        $result = $model->connectUser($userName, $userPassword); //Return userId is success, else return false

        if (!$result) {
            $json = json_encode($result);
            echo ($json);
        } else {
            $authController = new \Controllers\AuthorisationController();
            $authController->connectUser($userName, $userPassword, $result);
        }
        // Should return User_ID
        //$json = json_encode($result);
        //echo ($json);
    }

    public function createUser()
    {
        // Check if username don't already exists

        $content = file_get_contents("php://input");
        $data = json_decode($content, true);

        $userName = $data['userName'];
        $userPassword = $data['userPassword'];

        /*
        $json = json_encode($data);
        echo ($json);*/

        $model = new \Models\Database();
        $result = $model->createUser($userName, $userPassword);
        //echo $result;
        //exit;
        $authController = new \Controllers\AuthorisationController();
        $authController->connectUser($userName, $userPassword, $result);

        //$json = json_encode($result);
        //echo ($json);
    }
}
