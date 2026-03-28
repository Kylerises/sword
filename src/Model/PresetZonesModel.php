<?php

namespace kylerises\Model;

use kylerises\Entity\PresetZonesEntity;

class PresetZonesModel extends PresetZonesEntity
{

    /**
     * @return array|false 
     */
    public function AllPresetZone(): array|false
    {
        return $this->getAllPresetZone();
    }

    /**
     * @param int $zone_id
     * @return array|false
     */
    public function getPresetZone(int $zone_id): array|false
    {
        return $this->getPresetZoneFromId($zone_id);
    }
}