<?php

namespace kylerises\Controller;

use kylerises\Model\PlayerZoneModel;
use kylerises\Model\PresetBossModel;
use kylerises\Model\RequirementZoneModel;
use kylerises\Model\RessourcesModel;

class BossController extends AppController
{
    protected $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new PresetBossModel();
    }

    /**
     * send a json with boss per zone
     * @return void
     */
    public function displayBossPerZone(): void
    {
        $playerZoneModel = new PlayerZoneModel();
        
        $zone_id = $playerZoneModel->actualPlayerZone($this->user_id);
        $boss = $this->model->allBossPerZone($zone_id['zone_id']);

        $this->successToJsonArr($boss);
    }

    /**
     * Start fight update the time when boss start
     * @return void
     */
    public function startFight(): void
    {
        $playerZoneModel = new PlayerZoneModel();

        $start = time();

        $playerZoneModel->newStartBossTime($start);

        $this->successToJson("Fight started");
    }

    /**
     * Stop fight call private fightProgress and reset time
     * @return void
     */
    public function stopFight(): void
    {
        $boss_id = $_POST['id'];

        $this->fightProgress($boss_id);
    }

    /**
     * fightProgress is the fight motor
     * TODO optimize the fight calcul but it work actually
     * @return void
     */
    private function fightProgress($boss_id): void
    {
        $bossModel = new PresetBossModel();
        $rssModel = new RessourcesModel();
        $playerZoneModel = new PlayerZoneModel();
        $requirementZoneModel = new RequirementZoneModel();

        $boss = $bossModel->bossPerId($boss_id);
        $rss = $rssModel->allRessource($this->user_id);
        $playerZone = $playerZoneModel->startBossTime($this->user_id);
        $actualZone = $playerZoneModel->actualPlayerZone($this->user_id);

        $zone_id = $actualZone['zone_id'];
        $reqs = $requirementZoneModel->requirementZoneByUserIdAndZoneId($this->user_id, $zone_id);

        $start = $playerZone['start_boss_time'];
        $now = time();

        $boss_hp = $boss['boss_hp'];
        $boss_win = $boss['boss_win'];

        $dps = $rss['total_power'] ?? '0';
        $pps = $rss['power_per_second'] ?? '0';

        $playerWin = $rss['win'];
        $playerKills = $reqs['boss_kill'];
        $lastBoss = $reqs['boss_id'];

        $elapsed = $now - (int)$start;

        $damage = bcmul($dps, (string)$elapsed);

        $kills = bcdiv($damage, $boss_hp, 0);

        $wins = bcmul($kills, $boss_win);

        $totalWins = bcadd($playerWin, $wins);
        $totalDbKills = bcadd($playerKills, $kills);

        $rssModel->setStats('win', $totalWins);

        if ($boss_id == $lastBoss) {
            $requirementZoneModel->newRequirementZonePlayer($zone_id, 'boss_kill', $totalDbKills);
        }

        $data = [
            'kills' => $kills,
            'elapsed' => $elapsed,
            'wins' => $wins,
            'damage' => $damage
        ];

        $playerZoneModel = new PlayerZoneModel();

        $playerZoneModel->newStartBossTime($this->user_id, 0);

        $this->successToJsonArr($data);
    }

    /**
     * page view
     * @return void
     */
    public function index(): void
    {
        $this->render("boss");
    }
}