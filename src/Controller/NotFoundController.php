<?php

namespace kylerises\Controller;

class NotFoundController extends AppController
{
    /**
     * views page 
     *
     * @return void
     */
    public function index()
    {
        $this->render("notfound");
    }
}
