<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/Config.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/Database.class.php';

// Get config
$config = new Config();

// Init database
$db = new Database($config::$dbHost, $config::$dbUser, $config::$dbPass, $config::$db, $config::$charset);
