<?php

namespace views;


class Graph
{
    public function prepareDataForOutput($data)
    {
        $newData = [];

        foreach ($data as $element) {
            $newData[] = [
                'x_value' => $element['x_value'],
                'y_value' => $element['y_value'],
                'graphName' => htmlspecialchars($element['graphName']) // Sanitize the name
            ];
        }

        return $newData;
    }
}
