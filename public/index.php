<?php
/**
 * Front controller — point d'entrée unique de l'application
 */

session_start();

require_once dirname(__DIR__) . '/config/config.php';
require_once ROOT_PATH . '/app/core/Database.php';
require_once ROOT_PATH . '/app/core/Auth.php';
require_once ROOT_PATH . '/app/core/Router.php';

// Détermine l'URL demandée (fonctionne avec ou sans mod_rewrite)
if (isset($_GET['url'])) {
    $url = $_GET['url'];
} else {
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $url = trim(substr($path, strlen($scriptDir)), '/');
}

$router = new Router();
$router->dispatch($url);
