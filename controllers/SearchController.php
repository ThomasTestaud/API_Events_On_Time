<?php

namespace Controllers;

class SearchController
{

    public function displaySearch()
    {
        //Get the Json from the Ajax
        $content = file_get_contents("php://input");
        $data = json_decode($content, true);

        //Store data
        $search = $data['textToFind'];

        //Fetch the SQL method
        $model = new \Models\Search();
        $results = $model->searchUsers($search);

        //Call the view
        include_once 'views/_search_result.phtml';
    }
}
