<?php

namespace kylerises\Entity;

use kylerises\Model\Model;

class PresetZonesEntity extends Model
{
    protected $table = 'preset_zones';

    /**
     * @return array|false
     */
    protected function getAllPresetZone(): array|false
    {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->request($query);
        return $stmt->fetchAll() ?? false;
    }

    /**
     * @param int $zone_id
     * @return array|false
     */
    protected function getPresetZoneFromId(int $zone_id): array|false
    {
        $query = " SELECT * FROM {$this->table} WHERE zone_id = :zone_id";
        $stmt = $this->request($query, ['zone_id' => $zone_id]);
        return $stmt->fetch() ?? false;
    }
}