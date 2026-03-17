<?php

namespace kylerises\Model;

use kylerises\Entity\RequirementZoneEntity;

class RequirementZoneModel extends RequirementZoneEntity
{
    /**
     * Récupère toutes les requirements stats zone d'un utilisateur
     * @param int $user_id
     * @return array|false
     */
    public function allRequirementZoneByUserId(int $user_id): array|false
    {
        return $this->getAllRequirementZoneByUserId($user_id);
    }

    /**
     * Récupère les stats pour les requirement d'une zone
     * @param int $user_id
     * @param int $zone_id
     * @return array|false
     */
    public function requirementZoneByUserIdAndZoneId(int $user_id, int $zone_id): array|false
    {
        return $this->getRequirementZoneByUserIdAndZoneId($user_id, $zone_id);
    }
}