<?php

namespace Models;


class Graphs extends Database
{
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
        $req = "DELETE Graphs, Events
                FROM Graphs
                LEFT JOIN Events ON Events.graph_id = Graphs.id
                WHERE Graphs.id = :graphId
                AND user_id = :userId;";

        $params = [
            "userId" => $userId,
            "graphId" => $graphId
        ];

        $query = $this->bdd->prepare($req);
        $query->execute($params);
    }
}
