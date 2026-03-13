<?php

use kylerises\Core\App;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//On définie une constante contenant le dossier racine du projet
define('ROOT', dirname(__DIR__));

//On importe l'autoloader
require_once '../vendor/autoload.php';

// On vas instancie App (notre router)
$app = new App();

// On démarre l'application en appelant notre function run
$app->run();
