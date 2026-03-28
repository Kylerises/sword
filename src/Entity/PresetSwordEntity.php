<?php

namespace kylerises\Entity;

use kylerises\Model\Model;

class PresetSwordEntity extends Model
{
    protected $table = 'preset_sword';

    /**
     * @return array
     */
    protected function getAllSwordPreset(): array
    {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->request($query);
        return $stmt->fetchAll() ?? [];
    }

    /**
     * @param int $sword_id
     * @return array|false
     */
    protected function getSwordPresetById(int $sword_id): array|false
    {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->request($query, ['id' => $sword_id]);
        return $stmt->fetch() ?? false;
    }
}