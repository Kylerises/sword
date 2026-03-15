<?php

namespace kylerises\Model;

use kylerises\Entity\PresetSwordEntity;

class PresetSwordModel extends PresetSwordEntity
{
    /**
     * Récupère toutes les épées et leurs contenus
     * @return array
     */
    public function AllSwordPreset(): array
    {
        return $this->getAllSwordPreset();
    }

    /**
     * Récupère une épée et son contenu
     * @param int $sword_id
     * @return array|false
     */
    public function swordPreset(int $sword_id): array|false
    {
        return $this->getSwordPresetById($sword_id);
    }
}