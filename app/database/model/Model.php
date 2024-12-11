<?php
namespace App\Database\Model;

use App\Database\Database;


class Model
{
    public function __construct(protected $database, protected $table = null) {
        if(!$table) {
            /*
             * todo:
             * use a better algorithm for pluralizing
             * should also check if the table exists
             */
            $classname = strtolower($this::class);
            $this->table = (
                            ($pos = strrpos($classname, '\\')) ? 
                            substr($classname, $pos + 1) : 
                            $classname
            ) . 's';
        }
    }

    public function query($sql = '') : array
    {
        if(!$this->database->isOpen()) {
            throw new \Exception('database not opened');
        }

        if(empty($sql)) {
            $sql = "SELECT * FROM " . $this->table;
        }
        return $this->database
                        ->connection
                        ->query($sql)->fetchAll();
    }

    public function search($filter)
    {
        return $this->query("SELECT * FROM " . $this->table . " " . $filter);
    }

    public function create($data)
    {

    }

}