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

        $model = new \Models\Users();
        $result = $model->connectUser($userName, $userPassword); //Return userId is success, else return false

        if (!$result) {
            $json = json_encode($result);
            echo ($json);
        } else {
            $authController = new \Controllers\AuthorisationController();
            $authController->connectUser($userName, $userPassword, $result);
        }
    }

    public function createUser()
    {
        // Check if username don't already exists

        $content = file_get_contents("php://input");
        $data = json_decode($content, true);

        $userName = $data['userName'];
        $userPassword = $data['userPassword'];

        $model = new \Models\Users();
        $result = $model->createUser($userName, $userPassword);

        $result = ['id' => $result]; // Format same as other methods

        $authController = new \Controllers\AuthorisationController();
        $authController->connectUser($userName, $userPassword, $result);
    }
}
