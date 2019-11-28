<?php

namespace Src;

class Database
{
    protected $db = null;

    /**
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $dbname
     * @param int $port
     */
    public function __construct($host, $user, $password, $dbname, $port)
    {
        try {
            $this->db = new \PDO(
                "mysql:host=$host;port=$port;charset=utf8mb4;dbname=$dbname",
                $user,
                $password
            );
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * @return object
     */
    public function getLink()
    {
        return $this->db;
    }
}
