<?php

namespace kylerises\Core;

use kylerises\Controller\HomeController;
use kylerises\Controller\NotFoundController;

class App
{
    /**
     * Fonction qui démarre l'application
     *
     * @return void
     */
    public function run(): void
    {
        // On démarre la session
        session_start();

        // Récupérer l'URL demandée
        $uri = $_SERVER['REQUEST_URI'];

        // On retire le "trailing slash" éventuel de l'URL
        // On récupère l'URL
        if (!empty($uri) && $uri != Constants::PATH && $uri[-1] === '/') {
            // On enlève le /
            $uri = substr($uri, 0, -1);

            // On envoie un code de redirection permanente
            http_response_code(301);

            // On redirige vers l'URL sans /
            header('Location: ' . $uri);
            exit;
        }

        // On gère les paramètres d'URL
        // p=controller/methode/paramètres
        // On sépare les paramètres dans un tableau
        $params = [];
        if (isset($_GET['p'])) {
            $params = explode("/", $_GET["p"]);
        }

        if (!empty($params[0])) {
            $namespacePrefix = '\\kylerises\\Controller\\';

            if (empty($params[0]) || is_null($params[0])) {
                    // On n'a pas de paramètres
                    // On instancie le controller par défaut
                    $controller = new HomeController();

                    // On appelle la méthode index
                    $controller->index();
                    exit;
                }

            // On crée le nom de notre contrôleur
            $controllerName = ucfirst(array_shift($params)) . 'Controller';

            // On ajoute le préfixe à notre contrôleur
            $controller = $namespacePrefix . $controllerName;

            // Si la classe du contrôleur n'existe pas
            if (!class_exists($controller)) {
                http_response_code(404);
                // On instancie le contrôleur par défaut
                $controller = new NotFoundController();
                $controller->index();
                exit;
            }

            // On instancie le contrôleur
            $controller = new $controller();

            // On récupère le 2ème paramètre d'URL
            $action = isset($params[0]) ? array_shift($params) : "index";

            if (method_exists($controller, $action)) {
                // Si il reste des paramètres on les passe à la méthode
                isset($params[0]) ? call_user_func_array([$controller, $action], $params) : $controller->$action();
            } else {
                http_response_code(404);
                // On instancie le contrôleur par défaut
                $controller = new NotFoundController();
                $controller->index();
            }
        } else {
            // On n'a pas de paramètres
            // On instancie le contrôleur par défaut
            $controller = new HomeController();
            $controller->index();
        }
    }
}
