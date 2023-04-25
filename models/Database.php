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
            echo 'error at connection to DDB';
        }
    }

    public function getAll($user_id)
    {
        $req = "SELECT * FROM `compt` WHERE `user_id` = :user_id";

        $params = [
            'user_id' => $user_id
        ]

        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetchAll();
    }
}
