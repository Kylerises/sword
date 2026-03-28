<?php

namespace kylerises\Controller;

use kylerises\Model\PlayerSwordModel;
use kylerises\Model\PresetSwordModel;
use kylerises\Model\RessourcesModel;

class SwordController extends AppController
{
    protected $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new PresetSwordModel();
    }

    /**
     * Endpoint to display all sword
     * @return void
     */
    public function displayAllSword(): void
    {
        $swords = $this->model->AllSwordPreset();
        $rssModel = new RessourcesModel();
        $swordPlayerModel = new PlayerSwordModel();

        $swordData = $swordPlayerModel->actualPlayerSword($this->user_id);

        $actualSword = $swordData['sword_id'];

        $power = $rssModel->getTotalPower($this->user_id);

        $data = [];

        foreach($swords as $sword) {
            $data[] = [
                'id' => $sword['id'],
                'sword_name' => $sword['sword_name'],
                'sword_power' => $sword['sword_power'],
                'sword_power_required' => $sword['sword_power_required'],
                'images' => $sword['images'],
                'power' => $power,
                'actual_sword' => $actualSword
            ];
        }

        $this->successToJsonArr($data);
    }

    /**
     * view page
     * @return void
     */
    public function index(): void
    {
        $this->render("sword");
    }
}