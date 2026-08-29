<?php
/**
 * Router - dispatch les URL du type controleur/action/param1/param2...
 * vers app/controllers/ControleurController.php -> action(...)
 */
class Router
{
    public function dispatch(string $url): void
    {
        $url = trim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $parts = $url === '' ? [] : explode('/', $url);

        $controllerName = !empty($parts[0]) ? ucfirst(strtolower($parts[0])) : 'Auth';
        $action = $parts[1] ?? 'index';
        $params = array_slice($parts, 2);

        $controllerClass = $controllerName . 'Controller';
        $controllerFile = ROOT_PATH . '/app/controllers/' . $controllerClass . '.php';

        if (!file_exists($controllerFile)) {
            $this->notFound();
            return;
        }

        require_once $controllerFile;

        if (!class_exists($controllerClass)) {
            $this->notFound();
            return;
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $action)) {
            $this->notFound();
            return;
        }

        call_user_func_array([$controller, $action], $params);
    }

    private function notFound(): void
    {
        http_response_code(404);
        require ROOT_PATH . '/app/views/errors/404.php';
    }
}
