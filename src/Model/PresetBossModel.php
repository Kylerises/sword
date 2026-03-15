<?php

namespace kylerises\Model;

use kylerises\Entity\PresetBossEntity;

class PresetBossModel extends PresetBossEntity
{
    /**
     * Récupère tout les boss d'une zone
     * @param int $zone_id
     * @return array|false
     */
    public function allBossPerZone(int $zone_id): array|false
    {
        return $this->getAllBossPerZone($zone_id);
    }

    /**
     * Récupère infos d'un boss par son id et sa zone
     * @param int $boss_id
     * @param int $zone_id
     * @return array|false
     */
    public function bossPerIdAndZone(int $boss_id, int $zone_id): array|false
    {
        return $this->getBossPerIdAndZone($boss_id, $zone_id);
    }
}