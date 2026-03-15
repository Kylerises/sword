<?php

namespace kylerises\Controller;

use kylerises\Model\PresetSwordModel;

class SwordController extends AppController
{
    protected $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new PresetSwordModel();
    }

    /**
     * AJX afficher les épées
     */
    public function displayAllSword()
    {
        $swords = $this->model->AllSwordPreset();

        $this->successToJsonArr($swords);
    }

    public function index()
    {
        $this->render("sword");
    }
}