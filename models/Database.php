<?php

namespace Models;

require('config/config.php');

class Database
{

    protected $bdd;

    public function __construct()
    {
        try {
            $this->bdd = new \PDO('mysql:host=localhost:8889;dbname=events_on_time', 'root', 'root', [
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ]);
        } catch (\PDOException $e) {
            echo 'error at connection to DDB   ' . $e->getMessage();
        }
    }
    /*
    public function postNewEvent($graphId, $x_value, $y_value)
    {
        $req = "INSERT INTO `Events`(`graph_id`, `x_value`, `y_value`) 
                VALUES (:graphId, :x_value , :y_value)";

        $params = [
            "graphId" => $graphId,
            "x_value" => $x_value,
            "y_value" => $y_value,
        ];

        $query = $this->bdd->prepare($req);
        $query->execute($params);
    }

    public function getAllGraphsFromUser($userId)
    {
        $req = "SELECT name, type, id FROM `Graphs` WHERE user_id = :userId ORDER BY id DESC";

        $params = [
            "userId" => $userId
        ];

        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetchAll();
    }

    public function getAllEventsFromGraph($userId, $graphId)
    {
        $req = "SELECT x_value, y_value, Graphs.name as graphName, Graphs.type as graphType
                FROM `Events` 
                INNER JOIN `Graphs`
                ON Events.graph_id = Graphs.id
                WHERE Events.graph_id = :graphId AND Graphs.user_id = :userId";

        $params = [
            "userId" => $userId,
            "graphId" => $graphId
        ];

        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetchAll();
    }

    public function createNewGraph($userId, $graphName)
    {
        $req = "INSERT INTO `Graphs`(`user_id`, `name`) 
                VALUES (:userId,:graphName)";

        $params = [
            "userId" => $userId,
            "graphName" => $graphName
        ];

        $query = $this->bdd->prepare($req);
        $query->execute($params);
        // Retrieve the ID of the newly created line
        $lastInsertedId = $this->bdd->lastInsertId();

        return $lastInsertedId;
    }

    public function deleteGraph($userId, $graphId)
    {
        $req = "DELETE FROM `Graphs` WHERE id = :graphId AND user_id = :userId";

        $params = [
            "userId" => $userId,
            "graphId" => $graphId
        ];

        $query = $this->bdd->prepare($req);
        $query->execute($params);
    }

    public function deleteLastEvent($userId, $graphId)
    {
        $req = "DELETE FROM `Events` INNER JOIN Graphs ON graph_id = Graphs.id WHERE graph_id = :graphId AND Graphs.user_id = :userId ORDER BY Events.id DESC LIMIT 1";

        $params = [
            "userId" => $userId,
            "graphId" => $graphId
        ];

        $query = $this->bdd->prepare($req);
        $query->execute($params);
    }

    public function connectUser($userName, $userPassword)
    {
        $req = "SELECT id FROM `User` WHERE username = :userName AND password = :userPassword";

        $params = [
            "userName" => $userName,
            "userPassword" => $userPassword
        ];

        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetch();
    }

    public function createUser($userName, $userPassword)
    {
        $req = "INSERT INTO `User`(`username`, `password`) 
                VALUES ( :userName, :userPassword)";

        $params = [
            "userName" => $userName,
            "userPassword" => $userPassword
        ];

        $query = $this->bdd->prepare($req);
        $query->execute($params);

        // Retrieve the ID of the newly created line
        $lastInsertedId = $this->bdd->lastInsertId();

        return $lastInsertedId;
    }
    */
}
