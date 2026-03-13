<?php

namespace kylerises\Controller;

class HomeController extends AppController
{
    /**
     * Affiche la page d'accueil
     *
     * @return void
     */
    public function index(): void
    {
        if($this->isUserConnected()) {
            header('Location: ' . $this->path . 'game');
        }

        // On renvois la vue home/index
        $this->render("home");
    }
}
