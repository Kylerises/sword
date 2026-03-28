<?php

namespace kylerises\database;

use PDO;
use PDOException;

class Database extends PDO
{
    private static $instance;

    // write your own log to your DB
    private const DBHOST = "localhost";
    private const DBUSER = "root";
    private const DBPASS = "";
    private const DBNAME = "";

    private function __construct()
    {
        $_dsn = "mysql:dbname=" . self::DBNAME . ";host=" . self::DBHOST;

        try {
            parent::__construct($_dsn, self::DBUSER, self::DBPASS);

            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES utf8");
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : {$e->getMessage()}");
        }
    }

    /**
     * Return unique instance class
     *
     * @return self
     */
    public static function getInstance(): self
    {
        if (!self::$instance) 
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // can't duplicate
    private function __clone()
    {
    }

    // can't unserialize
    public function __wakeup()
    {
    }
}
