<?php

namespace kylerises\Controller;

class GameController extends AppController
{
    public function test()
    {
        
    }
    /**
     * Affiche la page game
     *
     * @return void
     */
    public function index(): void
    {
        // On renvois la vue game/index
        $this->render("game");
    }
}