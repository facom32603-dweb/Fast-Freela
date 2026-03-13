<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use PDO;

final class UserRepository
{
    public function findByEmail(string $email): ?array
    {
        $pdo = Database::pdo();
        $st = $pdo->prepare("SELECT * FROM users WHERE email = :email AND deleted_at IS NULL LIMIT 1");
        $st->execute(['email' => $email]);
        $row = $st->fetch();
        return $row ?: null;
    }

    public function findByEmailWithTrash(string $email): ?array
        {
            $pdo = Database::pdo();
            $st = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
            $st->execute(['email' => $email]);
            $row = $st->fetch();
            return $row ?: null;
        }

    public function findById(int $id): ?array
    {
        $pdo = Database::pdo();
        $st = $pdo->prepare("SELECT id, name, email, primary_role, is_admin, bio, created_at FROM users WHERE id=:id AND deleted_at IS NULL LIMIT 1");
        $st->execute(['id' => $id]);
        $row = $st->fetch();
        return $row ?: null;
    }

    public function create(string $name, string $email, string $passwordHash, string $role): int
    {
        $pdo = Database::pdo();
        $st = $pdo->prepare("INSERT INTO users (name, email, password_hash, primary_role) VALUES (:n,:e,:p,:r)");
        $st->execute(['n'=>$name,'e'=>$email,'p'=>$passwordHash,'r'=>$role]);
        return (int)$pdo->lastInsertId();
    }

    public function updateProfile(int $id, string $name, string $bio): void
    {
        $pdo = Database::pdo();
        $st = $pdo->prepare("UPDATE users SET name=:n, bio=:b WHERE id=:id AND deleted_at IS NULL");
        $st->execute(['n'=>$name,'b'=>$bio,'id'=>$id]);
    }

    public function listAll(): array
    {
        $pdo = Database::pdo();
        return $pdo->query("SELECT id, name, email, primary_role, is_admin, created_at, deleted_at FROM users ORDER BY created_at DESC")->fetchAll();
    }

    public function softDelete(int $id): void
    {
        $pdo = Database::pdo();
        $st = $pdo->prepare("UPDATE users SET deleted_at = NOW() WHERE id=:id");
        $st->execute(['id'=>$id]);
    }

    public function delete(int $id): bool
    {
        $pdo = Database::pdo();

        $stJobs = $pdo->prepare("DELETE FROM jobs WHERE user_id = :id");
        $stJobs->execute(['id' => $id]);

        $st = $pdo->prepare("DELETE FROM users WHERE id = :id");
        return $st->execute(['id' => $id]);
    }
}
