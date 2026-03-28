<?php

namespace kylerises\Controller;

class LogoutController extends AppController
{
    /**
     * View logout
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
        
        $this->render("logout");
    }
}
