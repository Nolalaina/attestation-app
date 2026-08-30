<?php
/**
 * Configuration générale de l'application
 */

// --- Base de données -------------------------------------------------
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'gestion_attestations');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// --- Application -------------------------------------------------------
define('APP_NAME', 'AttestPro');
define('APP_URL', 'http://localhost:8000');

// Dossier racine du projet
define('ROOT_PATH', dirname(__DIR__));

// Nombre de résultats par page (pagination admin)
define('PAGINATION_LIMIT', 10);

// Fuseau horaire
date_default_timezone_set('Indian/Antananarivo');

// Affichage des erreurs (mettre à 0 en production)
define('DEBUG', true);
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Polyfills de compatibilité PHP 7.4 (str_contains, str_starts_with, str_ends_with)
if (!function_exists('str_contains')) {
    function str_contains(string $haystack, string $needle): bool {
        return $needle === '' || strpos($haystack, $needle) !== false;
    }
}

if (!function_exists('str_starts_with')) {
    function str_starts_with(string $haystack, string $needle): bool {
        return strncmp($haystack, $needle, strlen($needle)) === 0;
    }
}

if (!function_exists('str_ends_with')) {
    function str_ends_with(string $haystack, string $needle): bool {
        return $needle === '' || substr($haystack, -strlen($needle)) === $needle;
    }
}
