<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;

final class CommentRepository
{
    public function listForJob(int $jobId): array
    {
        $pdo = Database::pdo();
        $st = $pdo->prepare("SELECT c.*, u.name AS user_name
            FROM job_comments c JOIN users u ON u.id=c.user_id
            WHERE c.job_id=:j AND c.deleted_at IS NULL
            ORDER BY c.created_at DESC");
        $st->execute(['j'=>$jobId]);
        return $st->fetchAll();
    }

    public function create(int $jobId, int $userId, string $content): void
    {
        $pdo = Database::pdo();
        $st = $pdo->prepare("INSERT INTO job_comments (job_id, user_id, content) VALUES (:j,:u,:c)");
        $st->execute(['j'=>$jobId,'u'=>$userId,'c'=>$content]);
    }
}
