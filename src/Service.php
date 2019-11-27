<?php

namespace Src;

abstract class Service
{
    protected $tableName;
    protected static $serviceName;
    protected $db;

    abstract public function create(array $data);
    abstract public function update(int $id, array $data);
    abstract public function find(int $id);
    abstract public function findAll();
    abstract public function delete(int $id);

    public function __construct(Database $db)
    {
        $this->db = $db->getLink();
    }

    protected function cleanInput($value = "")
    {
        $value = trim($value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);

        return $value;
    }
}
