<?php
/**
 * Front controller — point d'entrée unique de l'application
 */

session_start();

require_once dirname(__DIR__) . '/config/config.php';
require_once ROOT_PATH . '/app/core/Database.php';
require_once ROOT_PATH . '/app/core/Auth.php';
require_once ROOT_PATH . '/app/core/Router.php';

// Détermine l'URL demandée (fonctionne avec cli-server, Apache mod_rewrite, ou sous-dossier)
if (isset($_GET['url'])) {
    $url = $_GET['url'];
} else {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
    if (php_sapi_name() === 'cli-server') {
        $url = trim($path, '/');
    } else {
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        if ($scriptDir !== '/' && $scriptDir !== '.' && $scriptDir !== '\\' && strpos($path, $scriptDir) === 0) {
            $path = substr($path, strlen($scriptDir));
        }
        $url = trim($path, '/');
    }
}

$router = new Router();
$router->dispatch($url);
