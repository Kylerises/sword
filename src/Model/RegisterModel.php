<?php

namespace kylerises\Model;

use kylerises\Entity\UsersEntity;

class RegisterModel extends UsersEntity
{
    /**
     * Méthode pour enregistrer un utilisateur en base de données
     * @param array $data
     * @return bool
     */
    public function insertPlayer(array $data): bool
    {
        $isInsert = $this->insertPlayerIntoDb($data);

        if(!$isInsert) {
            return false;
            exit();
        }

        return true;
    }

    /**
     * Méthode qui vérifie si un nom d'utilisateur existe
     * @param string $username
     * @return bool
     */
    public function isUsernameExist(string $username): bool
    {
        return $this->getUsernameIfExist($username);
    }
}