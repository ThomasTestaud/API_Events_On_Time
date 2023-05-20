<?php

namespace Controllers;

class EventsController
{
    public function getEvents($graphId)
    {
        $model = new \Models\Database();
        $result = $model->getAllEventsFromGraph($graphId);

        $json = json_encode($result);
        echo ($json);
    }

    public function postNewEvent()
    {
        $content = file_get_contents("php://input");
        $data = json_decode($content, true);

        $graphId = $data['graphId'];
        $graphType = $data['graphType'];
        $x_value = time();
        $y_value = 1;

        $model = new \Models\Database();
        $model->postNewEvent($graphId, $x_value, $y_value);

        $this->getEvents($graphId);
    }

    public function deleteLastEvent()
    {
        $model = new \Models\Database();
        return $model->deleteLastEvent($_GET['graphId']);
    }
}
