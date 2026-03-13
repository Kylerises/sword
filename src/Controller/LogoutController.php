<?php

namespace kylerises\Controller;

class LogoutController extends AppController
{
    /**
     * Affiche la page de déconnexion
     *
     * @return void
     */
    public function index()
    {
        if(!$this->isUserConnected()) {
            header('Location: ' . $this->path . 'home');
        }
        
        if (isset($_SESSION['user'])) {
            session_destroy();
            header("Location:" . $this->path);
            exit;
        }
        
        // On renvois la vue logout/index
        $this->render("logout");
    }
}
