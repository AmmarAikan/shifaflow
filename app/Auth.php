<?php

declare(strict_types=1);

namespace ShifaFlow;

use PDO;

final class Auth
{
    private ?array $cachedUser = null;

    public function __construct(private readonly PDO $pdo)
    {
    }

    public function user(): ?array
    {
        if ($this->cachedUser !== null) {
            return $this->cachedUser;
        }

        $userId = $_SESSION['user_id'] ?? null;
        if (!is_int($userId) && !ctype_digit((string) $userId)) {
            return null;
        }

        $statement = $this->pdo->prepare('SELECT id, name, email, phone, role, gender, date_of_birth, address, is_active, created_at FROM users WHERE id = ? AND is_active = 1 LIMIT 1');
        $statement->execute([(int) $userId]);
        $user = $statement->fetch();

        if (!$user) {
            unset($_SESSION['user_id']);
            return null;
        }

        return $this->cachedUser = $user;
    }

    public function attempt(string $identifier, string $password): bool
    {
        $now = time();
        $attempts = $_SESSION['_login_attempts'] ?? ['count' => 0, 'until' => 0];
        if (($attempts['until'] ?? 0) > $now) {
            return false;
        }

        $statement = $this->pdo->prepare('SELECT * FROM users WHERE (email = :email_identifier OR phone = :phone_identifier) AND is_active = 1 LIMIT 1');
        $normalizedIdentifier = mb_strtolower(trim($identifier));
        $statement->execute([
            'email_identifier' => $normalizedIdentifier,
            'phone_identifier' => $normalizedIdentifier,
        ]);
        $user = $statement->fetch();

        $valid = $user && password_verify($password, $user['password_hash']);

        if (!$valid) {
            $count = (int) ($attempts['count'] ?? 0) + 1;
            $_SESSION['_login_attempts'] = [
                'count' => $count >= 5 ? 0 : $count,
                'until' => $count >= 5 ? $now + 60 : 0,
            ];
            return false;
        }

        if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
            $update = $this->pdo->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
            $update->execute([password_hash($password, PASSWORD_DEFAULT), $user['id']]);
        }

        session_regenerate_id(true);
        $_SESSION['user_id'] = (int) $user['id'];
        unset($_SESSION['_login_attempts']);
        $this->cachedUser = null;
        return true;
    }

    public function login(int $userId): void
    {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $userId;
        $this->cachedUser = null;
    }

    public function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
        $this->cachedUser = null;
    }

    public function check(): bool
    {
        return $this->user() !== null;
    }

    public function hasRole(string ...$roles): bool
    {
        $user = $this->user();
        return $user !== null && in_array($user['role'], $roles, true);
    }
}
