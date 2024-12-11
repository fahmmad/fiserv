<?php
require_once "../autoloader.php";

use App\Database\Database;
use App\Database\Model\Item;
use App\Controllers\FolderController;

$folderController =new FolderController;
$items = $folderController->get();

if(empty($items)) {
    $folderController->feedItems(__DIR__ . '/../.docker/database/data.txt');
    $items = $folderController->get();
}

echo "<table>";
foreach($items as $item) {
    echo "<tr><td colspan=" . $item["location"] . ">&nbsp;</td><td>" . $item["value"] . "</tr></td>";
}
echo "</table>";
?>

<hr/>
<form action="./index.php" method="post">
<div>
    <div><h3>Search</h3></div>
    <div><input type="text" name="search"></div>
    <div><input type="submit" value="search"></div>
</div>    
</form>

<?php

if(isset($_POST["search"])) {
    $result = $folderController->search($_POST["search"]);
    
    if($result) {
        
        foreach($result as $path) {
            $path = array_intersect_key($path, FolderController::KEYS);
            echo implode("/",$path)."<br/>";
        }
    }
}