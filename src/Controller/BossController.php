<?php

namespace kylerises\Controller;

use kylerises\Model\PresetBossModel;

class BossController extends AppController
{
    protected $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new PresetBossModel();
    }

    public function displayBossPerZone()
    {
        $boss = $this->model->allBossPerZone(1);

        $this->successToJsonArr($boss);
    }

    public function index()
    {
        $this->render("boss");
    }
}