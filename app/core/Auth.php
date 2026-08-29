<?php
/**
 * Auth - helpers d'authentification et de contrôle d'accès
 */
class Auth
{
    public static function login(array $user): void
    {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_nom'] = $user['nom'];
        $_SESSION['user_prenom'] = $user['prenom'];
        $_SESSION['user_email'] = $user['email'];
    }

    public static function logout(): void
    {
        $_SESSION = [];
        session_destroy();
    }

    public static function check(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public static function id(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    public static function role(): ?string
    {
        return $_SESSION['user_role'] ?? null;
    }

    public static function isAdmin(): bool
    {
        return self::check() && self::role() === 'admin';
    }

    public static function fullName(): string
    {
        return trim(($_SESSION['user_prenom'] ?? '') . ' ' . ($_SESSION['user_nom'] ?? ''));
    }

    /** Bloque l'accès si l'utilisateur n'est pas connecté */
    public static function requireLogin(): void
    {
        if (!self::check()) {
            header('Location: ' . APP_URL . '/auth/login');
            exit;
        }
    }

    /** Bloque l'accès si l'utilisateur n'est pas administrateur */
    public static function requireAdmin(): void
    {
        self::requireLogin();
        if (!self::isAdmin()) {
            header('Location: ' . APP_URL . '/etudiant/dashboard');
            exit;
        }
    }

    /** Bloque l'accès si l'utilisateur est administrateur (espace étudiant uniquement) */
    public static function requireEtudiant(): void
    {
        self::requireLogin();
        if (self::isAdmin()) {
            header('Location: ' . APP_URL . '/admin/dashboard');
            exit;
        }
    }

    /** Génère / vérifie un jeton CSRF simple */
    public static function csrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function verifyCsrf(?string $token): bool
    {
        return $token !== null && !empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}
