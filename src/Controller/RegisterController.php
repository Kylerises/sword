<?php

namespace kylerises\Controller;

use kylerises\Model\RegisterModel;

class RegisterController extends AppController
{
    protected $model;
    
    public function __construct()
    {
        parent::__construct();
        $this->model = new RegisterModel();
    }

    /**
     * Endpoint to register a user 
     * @return void
     */
    public function register(): void
    {

        $data = $this->sanitizeFormData($_POST);

        $username = $data['username'];

        $username = trim($username, ' ');
        $password = $data['password'];

        if(empty($username) || empty($password)) {
            $this->errorToJson("username and password can't be empty!");
        }

        $isExistUsername = $this->model->isUsernameExist($username);

        if($isExistUsername === true) {
            $this->errorToJson("username already exist !");
        }

        $passLength = strlen($password);
        if($passLength < 5) {
            
            $this->errorToJson("Your password must have 5 character. : actual character" . $passLength);
        }

        $hashPass = password_hash($password, PASSWORD_DEFAULT);

        $userInfo = [
            'username' => $username,
            'password' => $hashPass
        ];

        $isSuccess = $this->model->insertPlayer($userInfo);

        if($isSuccess) {
            $this->successToJson("Your account have been create.");
        }
    }
}