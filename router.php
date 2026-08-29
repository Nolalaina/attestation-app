<?php
/**
 * Routeur pour le serveur web intégré de PHP (php -S)
 */
$filePath = __DIR__ . '/public' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (is_file($filePath)) {
    return false;
}

require_once __DIR__ . '/public/index.php';
