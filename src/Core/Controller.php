<?php

namespace kylerises\Core;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

abstract class Controller
{
    private $loader;
    protected $twig;
    protected $path;
    protected $directory;

    public function __construct()
    {
        // On récupère le chemin de notre site web
        $this->path = Constants::PATH;

        // On paramètre le dossier contenant nos template
        $this->loader = new FilesystemLoader(ROOT . "/public/view/{$this->directory}");

        // On vas paramètrer l'environnement twig
        $this->twig = new Environment($this->loader, [
            'cache' => false, //ROOT . "/cache" en prod on met le cache a true,
            'debug' => Constants::DEBUG,
        ]);

        $this->twig->addExtension(new DebugExtension);
    }

    public function render(string $vue, array $donnees = [])
    {
        // On extrait le contenu de $donnees
        extract($donnees);

        // On ajoute directement les donnees qu'on veux sur tout le site
        foreach ($this->dataFullPage() as $key => $value) {
            $donnees[$key] = $value;
        }

        // On affiche la vue
        $this->twig->display($vue . "/index.twig", $donnees);
    }

    /**
     * On renvoie les datas qu'on veux sur toute nos page
     *
     * @return array
     */
    private function dataFullPage(): array
    {
        return [
            "path" => $this->path,
            "VERSION" => Constants::VERSION
        ];
    }
}
