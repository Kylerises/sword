<?php

namespace kylerises\Model;

use kylerises\Entity\RessourcesEntity;

class RessourcesModel extends RessourcesEntity
{
    /**
     * Récupère toutes les ressources d'un utilisateur
     * @param int $user_id
     * @return array|bool
     */
    public function allRessource(int $user_id): array|bool
    {
        return $this->getAllRessourceFromId($user_id);
    }

    /**
     * Récupère la puissance par seconde
     * @param int $user_id
     * @return string
     */
    public function getPowerPerSecond(int $user_id): string
    {
        $power = $this->getFieldAndValueFromId('power_per_second', $user_id);
        return $power['power_per_second'];
    }

    /**
     * Récupère la puissance total
     * @param int $user_id
     * @return string
     */
    public function getTotalPower(int $user_id): string
    {
        $power = $this->getFieldAndValueFromId('total_power', $user_id);
        return $power['total_power'];
    }

    /**
     * Récupère les victoires
     * @param int $user_id
     * @return string
     */
    public function getWins(int $user_id): string
    {
        $wins = $this->getFieldAndValueFromId('win', $user_id);
        return $wins['win'];
    }

    /**
     * Récupère le temps de la dernière update
     * @param int $user_id
     * @return int
     */
    public function getLastUpdate(int $user_id): int
    {
        $last = $this->getFieldAndValueFromId('last_update', $user_id);
        return $last['last_update'];
    }

    /**
     * Mets à jour un champ de l'utilisateur
     * @param string $field
     * @param mixed $data
     * @return bool
     */
    public function setStats(string $field, mixed $data): bool
    {
        return $this->setNewStats($field, $data);
    }
}