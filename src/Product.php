<?php

namespace Src;

/**
 * This is CRUD implementation of 'product' table in the database.
 */
class Product extends Service
{
    protected $tableName = 'product';
    public static $serviceName = 'product';
    protected $requiredFields = array('name', 'price');

    /**
     * @return array | string 
     */
    public function findAll()
    {
        $sql = "SELECT id, name, price FROM $this->tableName;";
        try {
            $statement = $this->db->query($sql);
            if ($statement->rowCount()) {
                return $statement->fetchAll(\PDO::FETCH_ASSOC);
            }
            return "There are no items in the table.";
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param integer $productId
     * @return array | string 
     */
    public function find(int $productId)
    {
        $sql = "SELECT id, name, price FROM $this->tableName WHERE id = :id;";
        try {
            $statement = $this->db->prepare($sql);
            $statement->execute(array('id' => $productId));
            if ($statement->rowCount()) {
                return $statement->fetchAll(\PDO::FETCH_ASSOC);
            }
            return 'The item is not found.';
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param array $data
     * @return string 
     */
    public function create(array $data)
    {
        $this->checkDataExistence($data);
        $sql = "INSERT INTO $this->tableName (name, price) VALUES (:name, :price);";
        try {
            $statement = $this->db->prepare($sql);
            $statement->execute(array(
                'name' => $this->cleanInput($data['name']),
                'price' => $this->cleanInput($data['price'])
            ));
            return "The item is successfully created.";
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param integer $productId
     * @param array $data
     * @return string
     */
    public function update(int $productId, array $data)
    {
        $this->checkDataExistence($data);
        $sql = "UPDATE $this->tableName SET name = :name, price = :price WHERE id = :id;";
        try {
            $statement = $this->db->prepare($sql);
            $statement->execute(array(
                'name' => $this->cleanInput($data['name']),
                'price' => $this->cleanInput($data['price']),
                'id' => $productId
            ));
            if ($statement->rowCount()) return "The item is successfully updated.";
            return "The item is not updated. Wrong id or your data doesn't have changes.";
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param integer $productId
     * @return string
     */
    public function delete(int $productId)
    {
        $sql = "DELETE FROM $this->tableName WHERE id = :id;";
        try {
            $statement = $this->db->prepare($sql);
            $statement->execute(array('id' => $productId));
            if ($statement->rowCount()) return "The item is successfully deleted.";
            return "The item is not found";
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
