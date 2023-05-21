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
        $result = $model->connectUser($userName, $userPassword);

        // Should return User_ID
        $json = json_encode($result);
        echo ($json);
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

        $json = json_encode($result);
        echo ($json);
    }
}
