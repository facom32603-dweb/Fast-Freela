<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\UserRepository;

final class AuthService
{
    public function __construct(private UserRepository $users) {}

    public function login(string $email, string $password): ?array
    {
        $user = $this->users->findByEmail($email);
        if (!$user) return null;
        if (!password_verify($password, $user['password_hash'])) return null;

        return [
            'id' => (int)$user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'primary_role' => $user['primary_role'],
            'is_admin' => (int)$user['is_admin'] === 1,
        ];
    }
}
