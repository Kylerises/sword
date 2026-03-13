<?php

namespace kylerises\Controller;

class NotFoundController extends AppController
{
    /**
     * Affiche la page d'erreur 404
     *
     * @return void
     */
    public function index()
    {
        // On renvois la vue notfound/index
        $this->render("notfound");
    }
}
