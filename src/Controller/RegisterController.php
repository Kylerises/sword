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
     * On récupère les données pour vérifier et entrée l'utilisateur en DB
     * @return void
     */
    public function register(): void
    {
        // on récupère les données entrées par l'utilisateur et on les sanitize
        $data = $this->sanitizeFormData($_POST);

        // on stocke les données
        $username = $data['username'];
        // on supprime les espaces du nom d'utilisateur en début et fin de chaîne
        $username = trim($username, ' ');
        $password = $data['password'];

        // on vérifie si champs ne sont pas vides sinon on retourne une erreur
        if(empty($username) || empty($password)) {
            $this->errorToJson("Le nom d'utilisateur ou le mot de passe ne peuvent pas être vide!");
        }

        // on vérifie si le nom d'utilisateur n'existe pas déjà
        $isExistUsername = $this->model->isUsernameExist($username);

        if($isExistUsername === true) {
            $this->errorToJson("Le nom d'utilisateur existe déjà !");
        }

        // Si les données ne sont pas vides on vérifie que le mot de passe contient au moins 5 caractères
        $passLength = strlen($password);
        if($passLength < 5) {
            
            $this->errorToJson("Le mot de passe doit contenir au minimum 5 caractères. Nombre de caractères actuelle: " . $passLength);
        }

        // si les données sont validées on va hasher le mot de passe
        $hashPass = password_hash($password, PASSWORD_DEFAULT);

        // on reconstruit un tableau avec les informations pour enregistrer l'utilisateur en DB
        $userInfo = [
            'username' => $username,
            'password' => $hashPass
        ];

        $isSuccess = $this->model->insertPlayer($userInfo);

        if($isSuccess) {
            $this->successToJson("Votre compte à bien été crée.");
        }
    }
}