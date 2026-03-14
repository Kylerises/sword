<?php

namespace kylerises\Model;

use kylerises\Database\Database;
use PDOException;

class Model
{
    protected $table;
    protected $db;

    /**
     * Constructeur de la classe Model
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Méthode qui permet de faire une requête à la base de données
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
     * Méthode qui permet de récupérer un enregistrement d'une table par son id
     *
     * @param int $id
     * @return array|bool
     */
    protected function selectById(int $id): array|bool
    {
        $query = $this->request('SELECT * FROM ' . $this->table . ' WHERE id = :id', [':id' => $id]);

        if ($query) {
            return $query->fetch();
        }

        return false;
    }

    /**
     * Méthode qui permet de supprimer un enregistrement d'une table par son id
     *
     * @param int $id
     * @return bool
     */
    protected function deleteById(int $id): bool
    {
        $query = $this->request('DELETE FROM ' . $this->table . ' WHERE id = :id', [':id' => $id]);

        if ($query) {
            return true;
        }
        return false;
    }

    /**
     * Méthode qui permet d'insérer un enregistrement dans une table
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
     * retourne l'id du joueur
     * @return int
     */
    protected function getUserId(): int
    {
        return $_SESSION['user'] ?? 1;
    }

    /**
     * @param array $data données
     * @return bool
     */
    protected function updateUser(array $data): bool
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

        return $this->request($sql, $params) ? true : false;
    }

    public function dump(mixed $data)
    {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
        exit;
    }
}
