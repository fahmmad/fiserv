<?php

namespace App\Database\Model;

use PDO;

class Item extends Model
{
   public function all()
   {
        $sql = "SELECT t1.name AS folder, t2.name as sub1, t3.name as sub2, t4.name as sub3
            FROM " . $this->table . " AS t1
            LEFT JOIN items AS t2 ON t2.parent = t1.id
            LEFT JOIN items AS t3 ON t3.parent = t2.id
            LEFT JOIN items AS t4 ON t4.parent = t3.id
            WHERE isNull(t1.parent)";

        return $this->query($sql);
   } 

   public function create($data)
   {
       $stmt = $this->database
                   ->connection
                   ->prepare("INSERT INTO " . $this->table . "(name, type, parent) VALUES (:name, :type, :parent)");
       $stmt->bindValue(":name", $data['name'], PDO::PARAM_STR);
       $stmt->bindValue(":type", $data['type'], PDO::PARAM_STR);
       $stmt->bindValue(":parent", $data['parent'] ? $data['parent'] : null, PDO::PARAM_INT);
       $stmt->execute();
   }

   public function pathSearch($search)
   {
        $result = [];
        if($search) {
            $stmt = $this->database
                ->connection
                ->prepare("SELECT t1.name AS folder, t2.name as sub1, t3.name as sub2, t4.name as sub3
                    FROM items AS t1
                    LEFT JOIN items AS t2 ON t2.parent = t1.id
                    LEFT JOIN items AS t3 ON t3.parent = t2.id
                    LEFT JOIN items AS t4 ON t4.parent = t3.id
                    WHERE (t1.name like :search OR t2.name like :search OR t3.name like :search OR  t4.name like :search) and isNull(t1.parent)");
            $stmt->bindValue(":search", "%" . $search . "%", PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll();
        }
        return $result;
   }
}