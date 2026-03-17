<?php

namespace kylerises\Model;

use kylerises\Entity\PlayerZoneEntity;

class PlayerZoneModel extends PlayerZoneEntity
{
    /**
     * Récupère la zone actuel de l'utilisateur
     * @param int $user_id
     * @return array|false
     */
    public function actualPlayerZone(int $user_id): array|false
    {
        return $this->getActualPlayerZone($user_id);
    }

    /**
     * Mets à jour la zone de l'utilisateur
     * @param int $user_id
     * @param int $zone_id
     * @return bool
     */
    public function newPlayerZone(int $user_id, int $zone_id): bool
    {
        return $this->setNewPlayerZone($user_id, $zone_id);
    }
}