<?php

namespace kylerises\Core;

use kylerises\Controller\HomeController;
use kylerises\Controller\NotFoundController;

class App
{
    /**
     * Start app
     *
     * @return void
     */
    public function run(): void
    {
        session_start();

        $uri = $_SERVER['REQUEST_URI'];

        if (!empty($uri) && $uri != Constants::PATH && $uri[-1] === '/') {

            $uri = substr($uri, 0, -1);

            http_response_code(301);

            header('Location: ' . $uri);
            exit;
        }

        $params = [];
        if (isset($_GET['p'])) {
            $params = explode("/", $_GET["p"]);
        }

        if (!empty($params[0])) {
            $namespacePrefix = '\\kylerises\\Controller\\';

            if (empty($params[0]) || is_null($params[0])) {

                    $controller = new HomeController();

                    $controller->index();
                    exit;
                }

            $controllerName = ucfirst(array_shift($params)) . 'Controller';

            $controller = $namespacePrefix . $controllerName;

            if (!class_exists($controller)) {
                http_response_code(404);
                $controller = new NotFoundController();
                $controller->index();
                exit;
            }

            $controller = new $controller();

            $action = isset($params[0]) ? array_shift($params) : "index";

            if (method_exists($controller, $action)) {
                isset($params[0]) ? call_user_func_array([$controller, $action], $params) : $controller->$action();
            } else {
                http_response_code(404);
                $controller = new NotFoundController();
                $controller->index();
            }
        } else {
            $controller = new HomeController();
            $controller->index();
        }
    }
}
