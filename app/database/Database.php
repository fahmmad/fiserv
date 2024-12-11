<?php
namespace App\Database;

use PDO;

class Database
{
    public $connection = null;
    public function __construct()
    {
        $this->open();
    }

    private function open()
    {
        $env = parse_ini_file('../.env');

        if(!$this->connection) {
            $this->connection = new PDO("mysql:host=" . $env['DB_HOST'] . ";dbname=" . $env['DB_DATABASE'], $env['DB_USER'], $env['DB_PASSWORD'], array(
                PDO::ATTR_PERSISTENT => true
            ));
        }
    }

    public function isOpen()
    {
        return ($this->connection !== null);
    }
}