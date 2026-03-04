<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;

final class FavoriteRepository
{
    public function isFavorited(int $userId, int $jobId): bool
    {
        $pdo = Database::pdo();
        $st = $pdo->prepare("SELECT 1 FROM job_favorites WHERE user_id=:u AND job_id=:j LIMIT 1");
        $st->execute(['u'=>$userId,'j'=>$jobId]);
        return (bool)$st->fetchColumn();
    }

    public function toggle(int $userId, int $jobId): void
    {
        $pdo = Database::pdo();
        if ($this->isFavorited($userId, $jobId)) {
            $st = $pdo->prepare("DELETE FROM job_favorites WHERE user_id=:u AND job_id=:j");
            $st->execute(['u'=>$userId,'j'=>$jobId]);
            return;
        }
        $st = $pdo->prepare("INSERT IGNORE INTO job_favorites (user_id, job_id) VALUES (:u,:j)");
        $st->execute(['u'=>$userId,'j'=>$jobId]);
    }

    public function listForUser(int $userId): array
    {
        $pdo = Database::pdo();
        $st = $pdo->prepare("SELECT j.*, u.name AS author_name
            FROM job_favorites f
            JOIN jobs j ON j.id=f.job_id
            JOIN users u ON u.id=j.author_id
            WHERE f.user_id=:u AND j.deleted_at IS NULL
            ORDER BY f.created_at DESC");
        $st->execute(['u'=>$userId]);
        return $st->fetchAll();
    }
}
