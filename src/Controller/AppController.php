<?php

namespace kylerises\Controller;

use kylerises\Core\Controller;

class AppController extends Controller
{
    protected $user_id;

    public function __construct()
    {
        parent::__construct();
        $this->user_id = $this->isUserConnected();
    }

    /**
     * clean form data
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
     * check if user is connected
     * @return ?int
     */
    protected function isUserConnected(): ?int
    {
        return $_SESSION['user'] ?? null;
    }

    /**
     * return json in case error
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
     * return json in case success
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
     * Return json array in case success
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
