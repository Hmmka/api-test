<?php

namespace Src;

/**
 * Extend this class if you would like to add a new service.
 */
abstract class Service
{
    protected $tableName;
    protected static $serviceName;
    protected $db;
    protected $requiredFields;

    abstract public function create(array $data);
    abstract public function update(int $id, array $data);
    abstract public function find(int $id);
    abstract public function findAll();
    abstract public function delete(int $id);

    /**
     * @param Database $db
     */
    public function __construct(Database $db)
    {
        $this->db = $db->getLink();
    }

    /**
     * @param string $value
     * @return string
     */
    protected function cleanInput($value = "")
    {
        $value = trim($value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);

        return $value;
    }

    /**
     * @param array $data
     * @return void
     */
    protected function checkDataExistence(array $data)
    {
        $missingKeys = [];
        foreach ($this->requiredFields as $key) {
            if (!array_key_exists($key, $data)) {
                $missingKeys[] = $key;
            }
        }
        if (count($missingKeys)) {
            throw new \Exception("There are missing required fields: " . implode(", ", $missingKeys));
        }
    }
}
