<?php

namespace kylerises\Controller;

use kylerises\Model\LoginModel;

class LoginController extends AppController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new LoginModel();
    }

    /**
     * Endpoint for log user
     * @return void
     */
    public function login(): void
    {
        $data = $this->sanitizeFormData($_POST);

        $username = $data['username'];
        $password = $data['password'];

        if(empty($username) || empty($password)) {
            $this->errorToJson("username and password can't be empty !");
        }

        $hashPassword = $this->model->getHashPassword($username);

        $isPasswordCorrect = password_verify($password, $hashPassword);

        if($isPasswordCorrect !== true) {
            $this->errorToJson("username or password is incorrect !");
        }

        $_SESSION['user'] = $this->model->getIdUser($username);
        
        $this->successToJson("Informations correct. redirect into game");
    }
}
