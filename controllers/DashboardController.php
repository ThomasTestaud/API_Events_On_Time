<?php

namespace Controllers;

class DashboardController
{

    public function displayDashboard(): void
    {
        echo 'hey';
        $model = new \Models\Articles();
        var_dump($model->getAllArticles());

        //Displaying the template
        $template = "dashboard.phtml";
        include_once 'views/layout.phtml';
    }
}
