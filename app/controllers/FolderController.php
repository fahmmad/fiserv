<?php
namespace App\Controllers;

use App\Database\Database;
use App\Database\Model\Item;

class FolderController
{
    const KEYS = ["folder", "sub1", "sub2", "sub3"];

    public function __construct(private $connection = new Database())
    {

    }

    public function get() : array
    {
        $results = [];

        try {
            $items = new Item($this->connection)->all();
            $current = null;
            
            while($next = next($items)) {
                $location = 0;
            
                if($current) {
                    foreach($next as $key => $value) {
                        if(!in_array($key, self::KEYS)) {
                            continue;
                        }
                        if(isset($current[$key]) && $current[$key] == $next[$key]) {
                            $location++;   
                        } else {
                            break;
                        }
                    }
                }
                $results = array_merge($results, $this->addItem($next, $location));
                $current = $next;
            }
            
        } catch(Exception $e) {
            /*
             * log this error
             */
            echo $e->getMessage();
        }
        return $results;
    }

    public function feedItems($file)
    {
        //echo $file;
        $tree = [];
        $delimiter = "\t";
        $fp = fopen($file, 'r');
        
        $modelItem = new Item($this->connection);

        while ( !feof($fp) )
        {
            $line = fgets($fp, 2048);
            $count = substr_count($line, "    ");
            $count += substr_count($line, $delimiter);
            $value = trim($line);
            if($count == 0) {
                $tree = [];
            }
            $tree[$count] = $value;
            $parent = 0;
            if($count > 0) {
                $filter = " WHERE type LIKE 'folder' AND name like '" . $tree[$count-1] . "'";
                $result = $modelItem->search($filter);
                if($result) {
                    $parent = $result[0]["id"];
                }                
            }
            $type = strpos($value, ".") === false ? 'folder' : 'file';
            $this->add($modelItem, $value, $type, $parent);
        }                              
        

        fclose($fp);
    }
    
    public function add($modelItem, $value, $type='folder', $parent = null)
    {
        return $modelItem->create(["name" => $value, "type" => $type, 'parent' => $parent]);
    }

    public function search($search)
    {
        $modelItem = new Item($this->connection);
        return $modelItem->pathSearch($search);
    }

    private function addItem($item, $location)
    {
        $result = [];
        foreach(self::KEYS as $index => $field) {
            if($index < $location || empty($item[$field])) {
                continue;
            }
            $result[] = [
                "location" => $index + 1,
                "value" => $item[ $field ],
            ];
        }
        return $result;
    }
}