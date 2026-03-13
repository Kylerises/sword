<?php

namespace kylerises\Entity;

use kylerises\Model\Model;

class UsersEntity extends Model
{
    protected $table = 'users';

    /**
     * Insertion de l'utilisateur en base de données
     * @param array $data
     * @return bool
     */
    protected function insertPlayerIntoDb(array $data): bool
    {
        $query = $this->insert($data);

        if(!$query) {
            return false;
            exit();
        }
        
        return true;
    }

    /**
     * Récupère nom d'utilisateur pour savoir si il est existant
     * @param string $username
     * @return bool
     */
    protected function getUsernameIfExist(string $username): bool
    {
        $query = "SELECT `username` FROM {$this->table} WHERE username = :username LIMIT 1";
        $stmt = $this->request($query, ['username' => $username]);
        
        if($stmt->rowCount() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Récupère le mot de passe d'un utilisateur par l'username
     * @param string $username
     * @return array|bool
     */
    protected function getPasswordHashFromUsername(string $username): array|bool
    {
        $query = "SELECT `password` FROM {$this->table} WHERE username = :username";
        $stmt = $this->request($query, ['username' => $username]);
        $data = $stmt->fetch();

        if(!$data) {
            return false;
        }

        return $data;
    }

    /**
     * Récupére l'id de l'utilisateur
     * @param string $username
     * @return array|bool
     */
    protected function getUserIdByUsername(string $username): array|bool
    {
        $query = "SELECT `id` FROM {$this->table} WHERE username = :username";
        $stmt = $this->request($query, ['username' => $username]);
        $data = $stmt->fetch();

        if(!$data) {
            return false;
        }

        return $data;
    }
}