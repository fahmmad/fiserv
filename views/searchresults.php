<?php

foreach($result as $path) {
    $path = array_intersect_key($path, $keys);
    echo implode("/",$path)."<br/>";
}