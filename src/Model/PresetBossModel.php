<?php

namespace kylerises\Model;

use kylerises\Entity\PresetBossEntity;

class PresetBossModel extends PresetBossEntity
{
    /**
     * @param int $zone_id
     * @return array|false
     */
    public function allBossPerZone(int $zone_id): array|false
    {
        return $this->getAllBossPerZone($zone_id);
    }

    /**
     * @param int $boss_id
     * @return array|false
     */
    public function bossPerId(int $boss_id): array|false
    {
        return $this->getBossPerId($boss_id);
    }
}