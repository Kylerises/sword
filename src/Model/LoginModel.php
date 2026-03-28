<?php

namespace kylerises\Model;

use kylerises\Entity\UsersEntity;

class LoginModel extends UsersEntity
{
    /**
     * @param string $username
     * @return string|bool
     */
    public function getHashPassword(string $username): string|bool
    {
        $hashPass = $this->getPasswordHashFromUsername($username);

        return $hashPass['password'] ?? false;
    }

    /**
     * @param string $username
     * @return int|bool
     */
    public function getIdUser(string $username): int|bool
    {
        $user_id = $this->getUserIdByUsername($username);

        return $user_id['id'] ?? false;
    }
}