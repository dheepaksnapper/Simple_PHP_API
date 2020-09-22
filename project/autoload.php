<?php
define('PROJECT_ROOT_PATH', __DIR__);
spl_autoload_register('my_autoloader');

function my_autoloader($classname) {

    // add the include path here
    $model_path = PROJECT_ROOT_PATH . '\\model\\' . $classname . '.php';
    $db_path = PROJECT_ROOT_PATH . '\\database\\' . $classname . '.php';
    $vendor_path = PROJECT_ROOT_PATH . '\\vendor\\jwt\\' . $classname . '.php';
    if (file_exists($model_path)) {
        include_once $model_path;
    } elseif (file_exists($db_path)) {
        include_once $db_path;
    } elseif (file_exists($vendor_path)) {
        echo "hit vendor if ";
        include_once $vendor_path;
    }

}