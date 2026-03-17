<?php

namespace kylerises\Model;

use kylerises\Entity\PresetZonesEntity;

class PresetZonesModel extends PresetZonesEntity
{

    /**
     * Récupère tout les presets des zones
     * @return array|false 
     */
    public function AllPresetZone(): array|false
    {
        return $this->getAllPresetZone();
    }

    /**
     * Récupère les preset d'une zone
     * @param int $zone_id
     * @return array|false
     */
    public function getPresetZone(int $zone_id): array|false
    {
        return $this->getPresetZoneFromId($zone_id);
    }
}