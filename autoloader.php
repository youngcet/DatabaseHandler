<?php

    spl_autoload_register (function ($class_name) {
        // load classes with namespaces in lib
        if (strpos ($class_name, '\\'))
        {
            // load classes by namespaces
            $class_name = str_replace ("\\", DIRECTORY_SEPARATOR, $class_name);
            include 'MySQL/'.$class_name . '.php';
        }
        else
        {
            // load classes
            include 'MySQL/'.$class_name . '.php';
        }
    });

?>