<?php

namespace kylerises\Model;

use kylerises\Entity\RequirementZoneEntity;

class RequirementZoneModel extends RequirementZoneEntity
{
    /**
     * @param int $user_id
     * @return array|false
     */
    public function allRequirementZoneByUserId(int $user_id): array|false
    {
        return $this->getAllRequirementZoneByUserId($user_id);
    }

    /**
     * @param int $user_id
     * @param int $zone_id
     * @return array|false
     */
    public function requirementZoneByUserIdAndZoneId(int $user_id, int $zone_id): array|false
    {
        return $this->getRequirementZoneByUserIdAndZoneId($user_id, $zone_id);
    }

    /**
     * @param int $zone_id
     * @param string $field
     * @param mixed $data
     * @return bool
     */
    public function newRequirementZonePlayer(int $zone_id, string $field, mixed $data): bool
    {
        return $this->setNewRequirementZonePlayer($zone_id, $field, $data);
    }
}