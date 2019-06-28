<?php

class Database extends Singleton
{
    private $databaseCache = [];

    /**
     * @param string $connectorName
     * @return \Slim\PDO\Database
     */
    public function getDatabase(string $connectorName)
    {
        if (!empty($this->databaseCache[$connectorName])) {
            return $this->databaseCache[$connectorName];
        }

        $databaseCredentials = Config::me()->get('databases');
        if (!isset($databaseCredentials[$connectorName])) {
            return null;
        }

        $credential = $databaseCredentials[$connectorName];
        try {
            $this->databaseCache[$connectorName] = new \Slim\PDO\Database(
                $credential['connection'],
                $credential['user'],
                $credential['password']
            );
        } catch (PDOException $e) {
            echo 'Database connect exception: ' . $e->getMessage();
            exit(1);
        }

        return $this->databaseCache[$connectorName];
    }

    /**
     * @param string $connectorName
     * @return \Slim\PDO\Database
     */
    public function getClonedDatabase(string $connectorName)
    {
        $databaseCredentials = Config::me()->get('databases');
        if (!isset($databaseCredentials[$connectorName])) {
            return null;
        }

        $credential = $databaseCredentials[$connectorName];
        try {
            $database = new \Slim\PDO\Database(
                $credential['connection'],
                $credential['user'],
                $credential['password']
            );
        } catch (PDOException $e) {
            echo 'Database connect exception: ' . $e->getMessage();
            exit(1);
        }

        return $database;
    }
}