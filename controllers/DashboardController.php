<?php

namespace Controllers;

class DashboardController {
    
    public function displayDashboard($articles_data): void
    {
        //Verify user is connected
        $model = new \Models\Users();
        $model->isConnected();
        
        //Sort out data to be redable for the template
        $articles = $articles_data[0];
        $comments = $articles_data[2];
        
        //Displaying the template
        $template = "dashboard.phtml";
        include_once 'views/layout.phtml';
    }

}