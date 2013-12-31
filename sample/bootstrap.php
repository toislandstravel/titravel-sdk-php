<?php
/**
 * Sample bootstrap file
 */

// Include the composer autoloader
if(!file_exists(__DIR__ .'/vendor/autoload.php')) {
    echo "The 'vendor' folder is missing. You must run 'composer install' to resolve application dependencies.\nPlease see the README for more information.\n";
    exit(1);
}
require __DIR__ . '/vendor/autoload.php';

// Include the configuration
if(!file_exists(__DIR__ .'/config.ini')) {
    echo "The 'config.ini' file is missing. You must have a configuration file to run the samples.\nPlease see the README for more information.\n";
    exit(1);
}
if(($config = parse_ini_file(__DIR__ .'/config.ini')) === false) {
    echo "The 'config.ini' is broken.\nPlease see the README for more information.\n";
    exit(1);
}
