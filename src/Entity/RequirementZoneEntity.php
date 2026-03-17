<?php

namespace kylerises\Entity;

use kylerises\Model\Model;

class RequirementZoneEntity extends Model
{
    protected $table = 'requirement_zone';

    /**
     * Récupère tout les stats pour les requirements zone
     * @param int $user_id
     * @return array|false 
     */
    protected function getAllRequirementZoneByUserId(int $user_id): array|false
    {
        $query = "SELECT * FROM {$this->table} WHERE user_id = :user_id";
        $stmt = $this->request($query, ['user_id' => $user_id]);
        return $stmt->fetchAll() ?? false;
    }


    /**
     * Récupère les stats pour les requirements zone
     * @param int $user_id
     * @param int $zone_id
     * @return array|false
     */
    protected function getRequirementZoneByUserIdAndZoneId(int $user_id, int $zone_id): array|false
    {
        $query = "SELECT * FROM {$this->table} WHERE user_id = :user_id AND zone_id = :zone_id";
        $stmt = $this->request($query, ['user_id' => $user_id, 'zone_id' => $zone_id]);
        return $stmt->fetch() ?? false;
    }
}