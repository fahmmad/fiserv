<?php

const APPS_PATH = '/app/';

spl_autoload_register( function () {

    $classes = [
        'database\Database',
        'database\model\Model',
        'database\model\Item',
        'controllers\FolderController',
    ];
    foreach($classes as $class) {
        $class = str_replace( '\\', '/', $class );
        $class = str_replace( '/\s+/', '', $class );
        $file = __DIR__ . APPS_PATH . $class . '.php';
     
        if ( file_exists( $file ) ) {
            require_once ( $file );
        }
    }
    return false;
} );