<?php

namespace kylerises\Entity;

use kylerises\Model\Model;

class UsersEntity extends Model
{
    protected $table = 'users';

    /**
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