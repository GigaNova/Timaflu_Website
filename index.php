<?php
include_once(__DIR__."/config/autoloader.php");
include_once(__DIR__."/core/errorhandler.php");
$config = include_once(__DIR__."/config/config.php");

error_reporting(E_ALL);
ini_set('display_errors', 'On');

(new \timaflu\core\Application($config))->start();