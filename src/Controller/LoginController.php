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
     * Méthode ajax pour connecter un utilisateur
     */
    public function login()
    {
        // On récupère et on sanitize les données entrée par l'utilisateur
        $data = $this->sanitizeFormData($_POST);
        // on stocke les données de l'utilisateur
        $username = $data['username'];
        $password = $data['password'];
        // on vérifie si les données sont valides
        if(empty($username) || empty($password)) {
            $this->errorToJson("Le nom d'utilisateur et/ou le mot de passe ne peuvent pas être vide !");
        }
        // on récupère le password hashé de l'utilisateur
        $hashPassword = $this->model->getHashPassword($username);
        // on vérifie le password et password hashé et on stocke le résultat
        $isPasswordCorrect = password_verify($password, $hashPassword);
        // on fait la vérif du password pour connecter ou non l'utilisateur
        if($isPasswordCorrect !== true) {
            $this->errorToJson("Le nom d'utilisateur et/ou le mot de passe sont incorrect !");
        }

        $_SESSION['user'] = $this->model->getIdUser($username);
        
        $this->successToJson("Informations correct. Redirection en jeu");
    }
}
