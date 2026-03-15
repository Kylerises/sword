<?php

namespace kylerises\Controller;

use kylerises\Core\Controller;

class AppController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Nettoyage des données du formulaire
     *
     * @param array $formData
     * @return array
     */
    protected function sanitizeFormData(array $data): array
    {
        $sanitizedData = [];
        foreach ($data as $key => $value) {
            if (is_array($value)) {

                $sanitizedData[$key] = $this->sanitizeFormData($value);
            } else {
                
                $sanitizedData[$key] = htmlspecialchars(trim($value));
            }
        }
        return $sanitizedData;
    }


    /**
     * Vérifie si l'utilisateur est connecté
     * @return ?int
     */
    protected function isUserConnected(): ?int
    {
        return $_SESSION['user'] ?? null;
    }

    /**
     * Retourne une json en cas d'erreur et stop le script
     * @param string $error
     */
    protected function errorToJson(string $error): void
    {
        header("Content-Type: application/JSON");

            echo json_encode([
                'error' => $error
                ]);

            exit();
    }

    /**
     * Retourne une json en cas de succés
     * @param string $success
     */
    protected function successToJson(string $success): void
    {
        header("Content-Type: application/JSON");

            echo json_encode([
                'success' => $success
                ]);
    }

    /**
     * Retourne une json en cas de succés
     * @param array $success
     */
    protected function successToJsonArr(array $success): void
    {
        header("Content-Type: application/JSON");

            echo json_encode([
                'success' => $success
                ]);
    }

    /**
     * debug
     * @param mixed $data
     * @return void
     */
    public function dump(mixed $data)
    {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
        exit;
    }

}
