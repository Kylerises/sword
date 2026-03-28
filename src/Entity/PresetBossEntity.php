<?php

namespace kylerises\Entity;

use kylerises\Model\Model;

class PresetBossEntity extends Model
{
    protected $table = 'preset_boss';

    /**
     * @param int $zone_id
     * @return array|false
     */
    protected function getAllBossPerZone(int $zone_id): array|false
    {
        $query = "SELECT * FROM {$this->table} WHERE boss_zone = :zone_id";
        $stmt = $this->request($query, ['zone_id' => $zone_id]);
        return $stmt->fetchAll() ?? false;
    }

    /**
     * @param int $boss_id
     * @return array|false
     */
    protected function getBossPerId(int $boss_id): array|false
    {
        $query = "SELECT * FROM {$this->table} WHERE boss_id = :boss_id";
        $stmt = $this->request($query, ['boss_id' => $boss_id]);
        return $stmt->fetch() ?? false;
    }
}