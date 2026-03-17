<?php

namespace kylerises\Entity;

use kylerises\Model\Model;

class PlayerZoneEntity extends Model
{
    protected $table = 'player_zone';

    /**
     * Récupère les infos de la zone de l'utilisateur
     * @param int $user_id
     * @return array|false
     */
    protected function getActualPlayerZone(int $user_id): array|false
    {
        $query = "SELECT * FROM {$this->table} WHERE user_id = :user_id";
        $stmt = $this->request($query, ['user_id' => $user_id]);
        return $stmt->fetch() ?? false;
    }

    /**
     * Mettre à jour la zone actuelle de l'utilisateur
     * @param int $user_id
     * @param int $zone_id
     * @return bool
     */
    protected function setNewPlayerZone(int $user_id, int $zone_id): bool
    {
        $data = [
            'user_id' => $user_id,
            'zone_id' => $zone_id
        ];

        return $this->updateUser($data);
    }
}