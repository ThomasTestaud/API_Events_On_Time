<?php

namespace Models;

require('config/config.php');

class Database
{

    protected $bdd;

    public function __construct()
    {
        try {
            $this->bdd = new \PDO('mysql:host=localhost;dbname=u112024506_general', 'u112024506_de', '7c~&6R0:Mp', [
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ]);
        } catch (\PDOException $e) {
            //redirique erreur 404
            echo 'error at connection to DDB';
            //die();
        }
    }

    public function getAllComp($user_id)
    {
        $req = "SELECT * FROM `compt` WHERE `user_id` = :user_id";

        $params = [
            'user_id' => $user_id
        ];

        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetchAll();
    }

    protected function getAll($req, $params = [])
    {
        $req = "SELECT * FROM `compt`";
        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetchAll();
    }

    protected function findOne($req, $params = [])
    {
        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetch();
    }

    protected function createNew($req, $params = [])
    {
        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $this->bdd->lastInsertId();
    }

    protected function update($req, $params = [])
    {
        $query = $this->bdd->prepare($req);
        $query->execute($params);
    }
}
