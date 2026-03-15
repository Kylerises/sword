<?php

namespace kylerises\Entity;

use kylerises\Model\Model;

class PresetBossEntity extends Model
{
    protected $table = 'preset_boss';

    /**
     * Récupère tout les boss par zone
     * @param int $zone_id
     * @return array|false
     */
    protected function getAllBossPerZone(int $zone_id): array|false
    {
        $query = "SELECT * FROM {$this->table} WHERE zone_id = :zone_id";
        $stmt = $this->request($query, ['zone_id' => $zone_id]);
        return $stmt->fetchAll() ?? false;
    }

    /**
     * Récupère infos d'un boss par son id et sa zone
     * @param int $boss_id
     * @param int $zone_id
     * @return array|false
     */
    protected function getBossPerIdAndZone(int $boss_id, int $zone_id): array|false
    {
        $query = "SELECT * FROM {$this->table} WHERE boss_id = :boss_id AND zone_id = :zone_id";
        $stmt = $this->request($query, ['boss_id' => $boss_id, 'zone_id' => $zone_id]);
        return $stmt->fetch() ?? false;
    }
}