<?php

namespace kylerises\Controller;

class GameController extends AppController
{
    /**
     * page view
     *
     * @return void
     */
    public function index(): void
    {
        $this->render("game");
    }
}