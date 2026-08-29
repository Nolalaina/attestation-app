<?php
/**
 * Configuration générale de l'application
 */

// --- Base de données -------------------------------------------------
define('DB_HOST', 'localhost');
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
ini_set('display_errors', 1);
error_reporting(E_ALL);
