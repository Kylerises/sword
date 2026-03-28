<?php

namespace kylerises\Controller;

use kylerises\Model\PlayerZoneModel;
use kylerises\Model\PresetZonesModel;
use kylerises\Model\RequirementZoneModel;
use kylerises\Model\RessourcesModel;

class ZonesController extends AppController
{
    /**
     * Endpoint to display actual zone
     * @return void
     */
    public function displayActualZone(): void
    {
        $playerZoneModel = new PlayerZoneModel();
        $actualZone = $playerZoneModel->actualPlayerZone($this->isUserConnected());

        $this->successToJson($actualZone['zone_id']);
    }

    /**
     * Endpoint to display all zone
     * @return void
     */
    public function displayAllZones(): void
    {
        $presetZoneModel = new PresetZonesModel();
        $requireModel = new RequirementZoneModel();
        $playerZoneModel = new PlayerZoneModel();

        $zones = $presetZoneModel->AllPresetZone();
        $boss = $requireModel->allRequirementZoneByUserId($this->user_id);
        $actualZone = $playerZoneModel->actualPlayerZone($this->isUserConnected());

        $data = [];

        foreach($zones as $zone) {

            $zone_id = $zone['zone_id'];
            $index = $zone_id -1;

            $data[] = [
                'zone_id' => $zone_id,
                'name' => $zone['name'],
                'images' => $zone['images'],
                'power_required' => $zone['power_required'],
                'win_required' => $zone['win_required'],
                'boss_name' => $zone['boss_name'],
                'last_boss_zone' => $zone['last_boss_zone'],
                'boss_zone_kill' => $zone['boss_zone_kill'],
                'boss_kill' => $boss[$index]['boss_kill'] ?? 0,
                'is_unlocked' => $boss[$index]['is_unlocked'] ?? 0,
                'actual_zone' => $actualZone['zone_id']
            ];
            
        }

        $this->successToJsonArr($data);
    }

    /**
     * Endpoint to unlock a zone
     * @return void
     */
    public function unlockZone(): void
    {
        $zone_id = $_POST['id'];

        $rssModel = new RessourcesModel();
        $presetZoneModel = new PresetZonesModel();
        $requireModel = new RequirementZoneModel();

        $rss = $rssModel->allRessource($this->user_id);
        $preset = $presetZoneModel->getPresetZone($zone_id);
        $requireZone = $requireModel->requirementZoneByUserIdAndZoneId($this->user_id, $zone_id);

        $power = $rss['total_power'];
        $win = $rss['win'];
        $boss_kill = $requireZone['boss_kill'];

        $power_required = $preset['power_required'];
        $win_required = $preset['win_required'];
        $boss_zone_kill = $preset['boss_zone_kill'];

        $notEnoughPower = bccomp($power, $power_required) < 0;
        $notEnoughWin   = bccomp($win, $win_required) < 0;
        $notEnoughBoss  = $boss_kill < $boss_zone_kill;

        if($notEnoughPower || $notEnoughWin || $notEnoughBoss) {
            $this->errorToJson("you don't encounter the requirements !");
        }

        $winLeft = bcsub($win, $win_required);

        $rssModel->setStats('win', $winLeft);

        $requireModel->newRequirementZonePlayer($zone_id, 'is_unlocked', 1);

        $this->successToJson("Zone: " . $zone_id . ' have been unlocked');
    }

    /**
     * Endpoint for teleport into new zone
     * @return void
     */
    public function tp(): void
    {
        $zone_id = $_POST['id'];

        $playerZoneModel = new PlayerZoneModel();

        $isTeleport = $playerZoneModel->newPlayerZone($zone_id);

        if($isTeleport) {
            $this->successToJson("teleportation in Zone: " . $zone_id);
        }
    }

    /**
     * page view
     * @return void
     */
    public function index(): void
    {
        $this->render('zones');
    }
}