<?php

namespace Models;


class Users extends Database
{
    public function connectUser($userName) //Return userId and hashedPassword
    {
        $req = "SELECT id as userId, password as hashedPassword FROM `User` WHERE username = :userName";

        $params = [
            "userName" => $userName
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

    public function usernameExist($userName)
    {
        $req = "SELECT username FROM `User` WHERE username = :userName";

        $params = [
            "userName" => $userName
        ];

        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetch();
    }
}
