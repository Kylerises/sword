<?php

namespace kylerises\Model;

use kylerises\Database\Database;
use PDOException;

class Model
{
    protected $table;
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     *
     * @param string $sql
     * @param array $params
     * @return PDOStatement|bool
     */
    protected function request($sql, $params = [])
    {
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            echo "Erreur de requête : " . $e->getMessage();
            return false;
        }
    }

    /**
     *
     * @param array $data
     * @return bool
     */
    protected function insert(array $data): bool
    {
        $sql = 'INSERT INTO ' . $this->table . ' (';
        $params = [];
        foreach ($data as $key => $value) {
            $sql .= $key . ', ';
            $params[':' . $key] = $value;
        }

        $sql = substr($sql, 0, -2);
        $sql .= ') VALUES (';
        foreach ($data as $key => $value) {
            $sql .= ':' . $key . ', ';
        }

        $sql = substr($sql, 0, -2);
        $sql .= ')';

        $query = $this->request($sql, $params);
        if ($query) {
            return true;
        }

        return false;
    }

    /**
     * @return int
     */
    protected function getUserId(): int
    {
        return $_SESSION['user'] ?? 1;
    }

    /**
     * @param array $data données
     * @param string $and
     * @return bool
     */
    protected function updateUser(array $data, string $and = ''): bool
    {
        $setParts = [];
        $params = [];

        foreach ($data as $key => $value) {
            $setParts[] = "$key = :$key";
            $params[$key] = $value;
        }

        $params['user_id'] = $this->getUserId();

        $sql = "UPDATE {$this->table}
                SET " . implode(', ', $setParts) . "
                WHERE user_id = :user_id";

        if($and !== '') {
            $sql = "UPDATE {$this->table}
            SET " . implode(', ', $setParts) . "
            WHERE user_id = :user_id $and";
        }

        return $this->request($sql, $params) ? true : false;
    }
}
