<?php

namespace kylerises\Entity;

use kylerises\Model\Model;

class PlayerZoneEntity extends Model
{
    protected $table = 'player_zone';

    /**
     * @param int $user_id
     * @return array|false
     */
    protected function getActualPlayerZone(int $user_id): array|false
    {
        $query = "SELECT `zone_id` FROM {$this->table} WHERE user_id = :user_id";
        $stmt = $this->request($query, ['user_id' => $user_id]);
        return $stmt->fetch() ?? false;
    }

    /**
     * @param int $zone_id
     * @return bool
     */
    protected function setNewPlayerZone(int $zone_id): bool
    {
        $data = [
            'zone_id' => $zone_id
        ];

        return $this->updateUser($data);
    }

    /**
     * @param int $user_id
     * @return array|false
     */
    protected function getStartBossTime(int $user_id): array|false
    {
        $query = "SELECT `start_boss_time` FROM {$this->table} WHERE user_id = :user_id";
        $stmt = $this->request($query, ['user_id' => $user_id]);
        return $stmt->fetch() ?? false;
    }

    /**
     * @param int $start
     * @return bool
     */
    protected function setNewStartBossTime(int $start): bool
    {
        $data = [
            'start_boss_time' => $start
        ];

        return $this->updateUser($data);
    }
}