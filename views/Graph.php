<?php

namespace views;


class Graph
{
    public function prepareDataForOutput($data)
    {
        $newData = [];

        foreach ($data as $element) {
            $newData[] = [
                'graphName' => htmlspecialchars($element['graphName']), // Sanitize the name
                'x_value' => $element['x_value'],
                'y_value' => $element['y_value'],
            ];
        }

        return $newData;
    }
}
