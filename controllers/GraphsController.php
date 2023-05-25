<?php

namespace Controllers;


class GraphsController
{
    public function getGraph()
    {
        $model = new \Models\Database();
        return $model->getAllEventsFromGraph($_GET['graphId']);
    }

    public function createNewGraph($userId)
    {
        $content = file_get_contents("php://input");
        $data = json_decode($content, true);

        $graphName = $data['graphName'];

        $model = new \Models\Database();
        $result = $model->createNewGraph($userId, $graphName);

        // Send back the ID of the created list
        echo $result;
    }

    public function deleteGraph()
    {
        $model = new \Models\Database();
        $model->deleteGraph($_GET['graphId']);
    }
}
