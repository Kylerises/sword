<?php

namespace kylerises\Entity;

use kylerises\Model\Model;

class PlayerSwordEntity extends Model
{
    protected $table = 'player_sword';

    /**
     * @param int $user_id
     * @return array|false
     */
    protected function getActualPlayerSword(int $user_id): array|false
    {
        $query = "SELECT * FROM {$this->table} WHERE user_id = :user_id";
        $stmt = $this->request($query, ['user_id' => $user_id]);
        return $stmt->fetch() ?? false;
    }

    /**
     * @param int $sword_id
     * @return bool
     */
    protected function saveNewSwordId(int $sword_id): bool
    {
        $data = [
            'sword_id' => $sword_id
        ];

        return $this->updateUser($data);
    }
}