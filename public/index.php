<?php

use kylerises\Core\App;

//On définie une constante contenant le dossier racine du projet
define('ROOT', dirname(__DIR__));

//On importe l'autoloader
require_once '../vendor/autoload.php';

// On vas instancie App (notre router)
$app = new App();

// On démarre l'application en appelant notre function run
$app->run();
