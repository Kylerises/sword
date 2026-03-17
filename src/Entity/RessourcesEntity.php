<?php

namespace kylerises\Entity;

use kylerises\Model\Model;

class RessourcesEntity extends Model
{
    protected $table = 'ressources';

    /**
     * Récupère toutes les ressources d'un utilisateur
     * @param int $user_id
     * @return array|bool
     */
    protected function getAllRessourceFromId(int $user_id): array|bool
    {
        $query = "SELECT * FROM {$this->table} WHERE user_id = :user_id";
        $stmt = $this->request($query, ['user_id' => $user_id]);
        return $stmt->fetch() ?? false;
    }

    /**
     * Récupère un champs et sa valeur
     * @param string $field champs
     * @param int $user_id
     * @return array|bool
     */
    protected function getFieldAndValueFromId(string $field, int $user_id): array|bool
    {
        $query = "SELECT {$field} FROM {$this->table} WHERE user_id = :id";
        $stmt = $this->request($query, ['id' => $user_id]);
        $data = $stmt->fetch();

        return $data ?? false;
    }

    /**
     * Mets à jour un champ et sa valeur
     * @param string $field champs
     * @param mixed $data
     * @param int $user_id
     * @return bool
     */
    protected function setNewStats(string $field, mixed $data): bool
    {
        return $this->updateUser([$field => $data]);
    }
}