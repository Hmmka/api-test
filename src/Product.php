<?php

namespace Src;

class Product extends Service
{
    protected $tableName = 'product';
    public static $serviceName = 'product';
    protected $requiredFields = array('name', 'price');

    public function findAll()
    {
        $sql = "SELECT id, name, price FROM $this->tableName;";
        try {
            $statement = $this->db->query($sql);
            if ($statement->rowCount()) {
                return $statement->fetchAll(\PDO::FETCH_ASSOC);
            }
            return 'undefined';
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
        return $this->query($statement);
    }

    public function find(int $productId)
    {
        $sql = "SELECT * FROM $this->tableName WHERE id = ?;";
        try {
            $statement = $this->db->prepare($sql);
            $statement->execute(array($productId));
            if ($statement->rowCount()) {
                return $statement->fetchAll(\PDO::FETCH_ASSOC);
            }
            return 'undefined';
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

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
            return $statement->rowCount();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

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
            return $statement->rowCount();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function delete(int $productId)
    {
        $sql = "DELETE FROM $this->tableName WHERE id = ?;";
        try {
            $statement = $this->db->prepare($sql);
            $statement->execute(array($productId));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
