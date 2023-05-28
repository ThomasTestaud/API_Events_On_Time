<?php

namespace Models;

require('config/config.php');

class Database
{

    protected $bdd;

    public function __construct()
    {
        try {
            $this->bdd = new \PDO('mysql:host=localhost;dbname=u112024506_events_on_time', 'u112024506_Toto', '=4ae^LZD>=eU', [
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ]);
        } catch (\PDOException $e) {
            echo 'error at connection to DDB   ' . $e->getMessage();
        }
    }
}
