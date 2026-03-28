<?php

namespace kylerises\Controller;

use kylerises\Model\PlayerSwordModel;
use kylerises\Model\PresetSwordModel;
use kylerises\Model\RessourcesModel;

class RessourcesController extends AppController
{
    protected $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new RessourcesModel();
    }

    /**
     * Endpoint to get all ressources from user
     * @return void
     */
    public function ressource(): void
    {
        $rss = $this->model->allRessource($this->user_id);
        $pps = $rss['power_per_second'];
        $power = $rss['total_power'];
        $win = $rss['win'];

        $this->successToJsonArr([
            'pps' => $pps,
            'power' => $power,
            'win' => $win
        ]);
    }

    /**
     * Endpoint display power
     * @return void
     */
    public function displayPower(): void 
    {
        $power = $this->model->getTotalPower($this->user_id);

        $this->successToJson($power);
    }

    /**
     * Endpoint diplsay PPS
     * @return void
     */
    public function displayPowerPerSecond(): void
    {
        $powerPerSecond = $this->model->getPowerPerSecond($this->user_id);

        $this->successToJson($powerPerSecond);
    }

    /**
     * Endpoint display win
     * @return void
     */
    public function displayWin():void
    {
        $wins = $this->model->getWins($this->user_id);

        $this->successToJson($wins);
    }

    /**
     * Endpoint to send power and pps
     * @return void
     */
    public function sendPowerAndPowerPerSec(): void
    {
        $power = $this->model->getTotalPower($this->user_id);
        $powerPerSecond = $this->model->getPowerPerSecond($this->user_id);

        $this->successToJsonArr(['power' => $power, 'pps' => $powerPerSecond]);
    }

    /**
     * Endpoint saveStats
     * @return void
     */
    public function saveStats(): void
    {
        if(is_null($this->isUserConnected())) {
            exit();
        }

        $lastUpdate = $this->model->getLastUpdate($this->user_id);
        $time = time();

        $elapse = $time - $lastUpdate;

        $pps = $this->model->getPowerPerSecond($this->user_id);
        $power = $this->model->getTotalPower($this->user_id);

        $tp = bcmul((string)$pps, (string)$elapse);
        $tp = bcadd($tp, (string)$power);

        $isPowerUpdate = $this->model->setStats('total_power', $tp);
        $isTimeUpdate = $this->model->setStats('last_update', $time);

        if($isPowerUpdate === false) {
            $this->errorToJson("power not update !");
        }

        if($isTimeUpdate === false) {
            $this->errorToJson("Time not update !");
        }

        $this->successToJson("saved !");
    }

    /**
     * Endpoint to save new pps after new sword unlock and equiped
     * @return void
     */
    public function savePpsAfterNewSword(): void
    {
        $swordModel = new PresetSwordModel();
        $playerSwordModel = new PlayerSwordModel();

        $playerSword = $playerSwordModel->actualPlayerSword($this->user_id);

        $actualSword = $playerSword['sword_id'];

        $nextSwordData = $swordModel->swordPreset($actualSword + 1);

        if($nextSwordData === false) {
            exit();
        }

        $power = $this->model->getTotalPower($this->user_id);

        if(bccomp($power, $nextSwordData['sword_power_required']) > 0) {
            $newSword = $actualSword + 1;

            $swordIsUpdate = $playerSwordModel->newSword($newSword);

            if($swordIsUpdate) {
                $newSwordData = $swordModel->swordPreset($newSword);

                $newPps = $newSwordData['sword_power'];
                $this->model->setStats('power_per_second', $newPps);

                $this->successToJson("New sword unlocked and equiped!");
                exit();
            }

            exit();

        }

        exit();
    }
}