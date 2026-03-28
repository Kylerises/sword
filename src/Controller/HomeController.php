<?php

namespace kylerises\Controller;

class HomeController extends AppController
{
    /**
     * view page
     *
     * @return void
     */
    public function index(): void
    {
        if($this->isUserConnected()) {
            header('Location: ' . $this->path . 'game');
        }

        $this->render("home");
    }
}
