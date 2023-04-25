<?php

namespace Controllers;

class ArticleController {
    
    public function getAllArticles()
    {
        //Fetch all visible articles and comments
        $articlesModel = new \Models\Articles();
        $articles_data = $articlesModel->getAllArticles();
        
        return $this->sortArticles($articles_data);
    }
    
    public function displayOneArticle()
    {
        //Verify user is connected
        $model = new \Models\Users();
        $model->isConnected();
        
        //Redirect to 404 if there is no ID in the get
        if(!isset($_GET['id'])) {
            header('Location: index.php?route=404');
            exit;
        }
        
        //Fetch the article
        $articlesModel = new \Models\Articles();
        $articles_data = $articlesModel->getOneArticleFromId($_GET['id']);
        
        //Sort and prepare data for the view
        $articles_data = $this->sortArticles($articles_data);
        $articles = $articles_data[0];
        $comments = $articles_data[1];
        $allComments = true;
        
        //Display view
        $template = "article.phtml";
        include_once 'views/layout.phtml';
    }
    
    public function writeNewArticle(): void
    {
        
        //Verify user is connected
        $model = new \Models\Users();
        $model->isConnected();
        
        //Set errors array
        $errors = [];
        
        //Set the article array
        if(array_key_exists('article-content', $_POST)) {
            $newArticle = [
                'user' => trim($_SESSION['user_data']['user_id']),
                'title' => trim($_POST['article-title']),
                'content' => trim($_POST['article-content']),
                'audio' => null,
                'image' => null
            ];
        }
        
        //Verify at least one of the three fields has been set
        if(empty($newArticle['content']) && empty($_FILES['article-audio']['name']) && empty($_FILES['article-image']['name'])) {
            $errors[] = "Veuillez remplir au moins l'un des trois champs";
        }
        
        //Verify content is not over 500 char
        if(strlen($newArticle['content']) > 500) {
            $errors[] = "Le texte ne dois pas dépasser les 500 charactère. Vous en avez saisi " . strlen($newArticle['content']);
        }
        
        //Verify audio
        if(!empty($_FILES['article-audio']['name'])) {
            
            //Call method that veryfy the audio
            $verifyaudio = new \Models\Uploads();
            $audio = $verifyaudio->verifyAudio('article-audio');
            
            //Sort out the errors of that method to add them to the current errors array
            foreach($audio['errors'] as $error){
                 $errors[] = $error;
            }
            
            //Add the file to the array
            $newArticle['audio'] = $audio['file'];
        }
        
        //Verify image
        if(!empty($_FILES['article-image']['name'])) {
            
            //Call method that veryfy the image
            $verifyimg = new \Models\Uploads();
            $img = $verifyimg->verifyImage('article-image');
            
            //Sort out the errors of that method to add them to the current errors array
            foreach($img['errors'] as $error){
                $errors[] = $error;
            }
            //Add the file to the array
            $newArticle['image'] = $img['file'];
        }
        
        //Write the article is there is no errors
        if(count($errors) == 0) {
            
            //Write in DDB
            $model = new \Models\Articles();
            $model->writeArticle($newArticle);
            
            //Notify the user and redirect
            $_SESSION['flying-notifications'][] = 'Votre post a bien été ajouté';
            header('Location: index.php?route=dashboard');
            exit;
        }
        
        //In case of erros, display the same page again
        //Fetch all articles and comments
        $articles_data = $this->getAllArticles();
        //Sort out data to be readable for the view
        $articles = $articles_data[0];
        $comments = $articles_data[2];
        //Call the view
        $template = "dashboard.phtml";
        include_once 'views/layout.phtml';
    }
    
    public function deleteArticle(): void
    {
        //Initialise variables
        $tokenSession = '0';
        $errors = [];
        
        //Fetching and storing the token of the article
        foreach($_SESSION['article-tokens'] as $entry) {
            if($entry['id'] == $_POST['article-id']) {
                $tokenSession = $entry['token'];
                break;
            }
        }
        
        if(empty($_POST['article-id'])){
            $_SESSION['flying-notifications'][] = "Erreur";
            $errors[] = "+1";
        }
        
        //Checking the article token is matching
        if($tokenSession !== $_POST['article-token']){
            $_SESSION['flying-notifications'][] = "Erreur, vous n'avez pas les droits pour supprimer cet article";
            $errors[] = "+1";
        }
        
        //Calling the Method and notifying the user 
        if(count($errors) === 0) {
            $model = new \Models\Articles();
            $model->deleteArticle($_POST['article-id']);
            
            $_SESSION['flying-notifications'][] = 'Votre post a bien été supprimé';
        }
        
        header('Location: index.php?route=dashboard');
        exit;
    }
    
    //In order to make only one SQL request to display all articles and comments, I needed this function to sort and filter all the data
    private function sortArticles($articles_data)
    {
        //Calling the Utilities Model to calculate how long it's been since the articles has been written
        $utilities = new \Models\Utilities();
        
        //If there is no $articles_data previously declared, redirecto to 404
        if(empty($articles_data)){
            header('Location: index.php?route=404');
            exit;
        }
        
        //Set the array that we will fill in
        $articles = [];
        $comments = [];
        
        //Separate and store articles and comments
        foreach($articles_data as $data){
            
            //If an article is already present in the $articles array, do not add it in
            //Set $push to true
            $push = true;
            
            //If the article from the $data we are processing is already in the $article array, $push will be set to false
            //If $push == true, that means we are processing a comment and not an article
            foreach($articles as $article){
                if($data['id'] === $article['id']){
                    $push = false;
                }
            }
            //Add articles to the $articles array
            if($push){
                $articles[] = [
                    'id' => $data['id'],
                    'username' => $data['username'],
                    'validate' => $data['article_validate'],
                    'image_path' => $data['image_path'],
                    'content' => $data['content'],
                    'article_image' => $data['article_image'],
                    'audio_file' => $data['audio_file'],
                    'time_stamp' => $utilities->calculateDate($data['time_stamp'])
                ];
            }
            
            //Add comments to the $comments array
            $comments[] = [
                'id' => $data['comment_id'],
                'article_id' => $data['comment_article_id'],
                'validate' => $data['comment_validate'],
                'content' => $data['comment_content'],
                'username' => $data['comment_username'],
                'image_path' => $data['comment_image'],
                'time_stamp' => $utilities->calculateDate($data['comment_time_stamp'])
            ];
        }
        
        ////////////////////////////////////
        //Create a filtered comments array to limit amount of comments under each post
        //More comments can be displayed using an Ajax request
        $lastId = 0;
        $count = 0;
        //Maximun number of comments displayed under each post
        $commentsAmount = 2;
        //Reverse the array to keep only the most recent comments
        $reverseComments = array_reverse($comments);
        //We will only push the first $commentsAmount of comments per article in the new $filteredComment array
        foreach($reverseComments as $comment){
            //If the comment we are processing is not from the same article as the comment before, we reset $count
            if($comment['article_id'] !== $lastId){
                $count = 0;
            }
            if($comment['validate'] !== 0 && $comment['article_id'] !== null){
                if($count < $commentsAmount){
                    if($comment['article_id'] === $lastId) {
                        $count++;
                    }
                    //Only if we havn't seen $commentsAmount of comments from the same article before this one, we will push this comment
                    $filteredComment[] = $comment;
                }
            }
            //Update the $lasId for the next iteration of the loop
            $lastId = $comment['article_id'];
        }
        //Reverse the array again to put back the comments in the chronologicle order
        $filteredComment = array_reverse($filteredComment);
        //////////////////////////////////////
        
        //create tokens for each article and each comment
        $_SESSION['article-tokens'] = [];
        foreach($articles as $article) {
            $_SESSION['article-tokens'][] = [
                'id' => $article['id'],
                'token' => bin2hex(random_bytes(10))
            ];
        }
        $_SESSION['comment-tokens'] = [];
        foreach($comments as $comment) {
            $_SESSION['comment-tokens'][] = [
                'id' => $comment['id'],
                'token' => bin2hex(random_bytes(10))
            ];
        }
        
        //prepare for output
        $articles_data = [
            $articles,
            $comments,
            $filteredComment
        ];
        
        //output the data
        return $articles_data;
    }

}