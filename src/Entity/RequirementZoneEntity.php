<?php

namespace kylerises\Entity;

use kylerises\Model\Model;

class RequirementZoneEntity extends Model
{
    protected $table = 'requirement_zone';

    /**
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

    /**
     * @param int $zone_id
     * @param string $field
     * @param mixed $data
     * @return bool
     */
    protected function setNewRequirementZonePlayer(int $zone_id, string $field, mixed $data): bool
    {
        $and = "AND zone_id = :zone_id";
        return $this->updateUser([$field => $data, 'zone_id' => $zone_id], $and);
    }
}