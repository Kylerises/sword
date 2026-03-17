<?php

namespace kylerises\Controller;

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
     * AJX pour récupérer toutes les ressources
     */
    public function ressource()
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
     * AJX pour afficher la puissance
     */
    public function displayPower()
    {
        $power = $this->model->getTotalPower($this->user_id);

        $this->successToJson($power);
    }

    /**
     * AJX pour afficher la puissance par seconde
     */
    public function displayPowerPerSecond()
    {
        $powerPerSecond = $this->model->getPowerPerSecond($this->user_id);

        $this->successToJson($powerPerSecond);
    }

    /**
     * AJX pour afficher les victoires
     */
    public function displayWin()
    {
        $wins = $this->model->getWins($this->user_id);

        $this->successToJson($wins);
    }

    /**
     * AJX pour envoyer power et power par seconde
     */
    public function sendPowerAndPowerPerSec()
    {
        $power = $this->model->getTotalPower($this->user_id);
        $powerPerSecond = $this->model->getPowerPerSecond($this->user_id);

        $this->successToJsonArr(['power' => $power, 'pps' => $powerPerSecond]);
    }

    /**
     * AJX pour save les stats
     */
    public function saveStats()
    {
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
            $this->errorToJson("Puissance non mis à jour !");
        }

        if($isTimeUpdate === false) {
            $this->errorToJson("Temps non mis à jour !");
        }

        $this->successToJson("Sauvegarde effectuée !");
    }
}