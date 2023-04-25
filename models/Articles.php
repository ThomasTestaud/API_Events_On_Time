<?php

namespace Models;

class Articles extends Database
{

    public function getAllArticles()
    {
        //echo 'model';
        //die();
        $req = "SELECT * FROM `compt`";
        return $this->findAll($req);
    }
}
