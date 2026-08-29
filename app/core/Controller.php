<?php
/**
 * Controller - classe de base pour tous les contrôleurs
 */
abstract class Controller
{
    /**
     * Charge un modèle
     */
    protected function model(string $model)
    {
        require_once ROOT_PATH . '/app/models/' . $model . '.php';
        return new $model();
    }

    /**
     * Affiche une vue avec un layout (header/footer) et des données
     */
    protected function view(string $view, array $data = [], bool $withLayout = true): void
    {
        extract($data);
        $viewFile = ROOT_PATH . '/app/views/' . $view . '.php';

        if (!file_exists($viewFile)) {
            die('Vue introuvable : ' . $view);
        }

        if ($withLayout) {
            require ROOT_PATH . '/app/views/layouts/header.php';
        }
        require $viewFile;
        if ($withLayout) {
            require ROOT_PATH . '/app/views/layouts/footer.php';
        }
    }

    /**
     * Redirige vers une route interne
     */
    protected function redirect(string $route): void
    {
        header('Location: ' . APP_URL . '/' . ltrim($route, '/'));
        exit;
    }

    /**
     * Renvoie une réponse JSON
     */
    protected function json($data): void
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    /**
     * Récupère et nettoie les données POST
     */
    protected function post(string $key, $default = null)
    {
        return isset($_POST[$key]) ? trim($_POST[$key]) : $default;
    }

    /**
     * Message flash (session) affiché sur la prochaine vue
     */
    protected function setFlash(string $type, string $message): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }
}
