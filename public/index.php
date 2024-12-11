<?php
require_once "../autoloader.php";

use App\Controllers\FolderController;

$folderController =new FolderController;
$items = $folderController->get();

if(empty($items)) {
    $folderController->feedItems(__DIR__ . '/../.docker/database/data.txt');
    $items = $folderController->get();
}

include "../views/filetree.php";

if(isset($_POST["search"])) {
    $result = $folderController->search($_POST["search"]);
    
    if($result) {
        $keys = FolderController::KEYS;
        include "../views/searchresults.php";
    }
}