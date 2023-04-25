<?php

namespace Models;

class Articles extends Database
{

    public function getAllArticles()
    {
        $req = "SELECT * FROM `compt`";
        return $this->findAll($req);
    }
}
