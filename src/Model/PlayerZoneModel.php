<?php

namespace kylerises\Model;

use kylerises\Entity\PlayerZoneEntity;

class PlayerZoneModel extends PlayerZoneEntity
{
    /**
     * @param int $user_id
     * @return array|false
     */
    public function actualPlayerZone(int $user_id): array|false
    {
        return $this->getActualPlayerZone($user_id);
    }

    /**
     * @param int $zone_id
     * @return bool
     */
    public function newPlayerZone(int $zone_id): bool
    {
        return $this->setNewPlayerZone($zone_id);
    }

    /**
     * @param int $user_id
     * @return array|false
     */
    public function startBossTime(int $user_id): array|false
    {
        return $this->getStartBossTime($user_id);
    }

    /**
     * @param int $start
     * @return bool
     */
    public function newStartBossTime(int $start): bool
    {
        return $this->setNewStartBossTime($start);
    }
}