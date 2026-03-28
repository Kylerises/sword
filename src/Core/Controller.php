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
        $this->path = Constants::PATH;

        $this->loader = new FilesystemLoader(ROOT . "/public/view/{$this->directory}");

        $this->twig = new Environment($this->loader, [
            'cache' => false,
            'debug' => Constants::DEBUG,
        ]);

        $this->twig->addExtension(new DebugExtension);
    }

    public function render(string $vue, array $donnees = [])
    {
        extract($donnees);

        foreach ($this->dataFullPage() as $key => $value) {
            $donnees[$key] = $value;
        }

        $this->twig->display($vue . "/index.twig", $donnees);
    }

    /**
     * return data on all page
     *
     * @return array
     */
    private function dataFullPage(): array
    {
        $isLogged = '';
        
        if (!empty($_SESSION['user'])) {
            $isLogged = true;
        }

        return [
            "path" => $this->path,
            "VERSION" => Constants::VERSION,
            "isLogged" => $isLogged
        ];
    }
}
