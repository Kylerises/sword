<?php

namespace kylerises\Model;

use kylerises\Entity\PlayerSwordEntity;

class PlayerSwordModel extends PlayerSwordEntity
{
    /**
     * @param int $user_id
     * @return array|false
     */
    public function actualPlayerSword(int $user_id): array|false
    {
        return $this->getActualPlayerSword($user_id);
    }

    /**
     * @param int $sword_id
     */
    public function newSword(int $sword_id): bool
    {
        return $this->saveNewSwordId($sword_id);
    }
}