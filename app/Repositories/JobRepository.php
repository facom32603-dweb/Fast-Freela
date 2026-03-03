<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;

final class JobRepository
{
    public function listOpen(string $q = ''): array
    {
        $pdo = Database::pdo();
        if ($q !== '') {
            $st = $pdo->prepare("SELECT j.*, u.name AS author_name
                FROM jobs j
                JOIN users u ON u.id = j.author_id
                WHERE j.deleted_at IS NULL AND u.deleted_at IS NULL
                  AND j.title LIKE :q
                ORDER BY j.created_at DESC");
            $st->execute(['q' => '%' . $q . '%']);
            return $st->fetchAll();
        }
        return $pdo->query("SELECT j.*, u.name AS author_name
            FROM jobs j
            JOIN users u ON u.id = j.author_id
            WHERE j.deleted_at IS NULL AND u.deleted_at IS NULL
            ORDER BY j.created_at DESC")->fetchAll();
    }

    public function find(int $id): ?array
    {
        $pdo = Database::pdo();
        $st = $pdo->prepare("SELECT j.*, u.name AS author_name
            FROM jobs j JOIN users u ON u.id=j.author_id
            WHERE j.id=:id AND j.deleted_at IS NULL LIMIT 1");
        $st->execute(['id'=>$id]);
        $row = $st->fetch();
        return $row ?: null;
    }

    public function create(int $authorId, string $title, string $description, string $jobDate, float $estimatedValue, ?string $hiringDetails): int
    {
        $pdo = Database::pdo();
        $st = $pdo->prepare("INSERT INTO jobs (author_id, title, description, job_date, estimated_value, hiring_details)
                             VALUES (:a,:t,:d,:jd,:v,:h)");
        $st->execute([
            'a'=>$authorId,'t'=>$title,'d'=>$description,'jd'=>$jobDate,'v'=>$estimatedValue,'h'=>$hiringDetails
        ]);
        return (int)$pdo->lastInsertId();
    }

    public function update(int $id, int $authorId, string $title, string $description, string $jobDate, float $estimatedValue, ?string $hiringDetails): void
    {
        $pdo = Database::pdo();
        $st = $pdo->prepare("UPDATE jobs SET title=:t, description=:d, job_date=:jd, estimated_value=:v, hiring_details=:h
                             WHERE id=:id AND author_id=:a AND deleted_at IS NULL");
        $st->execute(['t'=>$title,'d'=>$description,'jd'=>$jobDate,'v'=>$estimatedValue,'h'=>$hiringDetails,'id'=>$id,'a'=>$authorId]);
    }

    public function setStatus(int $id, int $authorId, string $status): void
    {
        $pdo = Database::pdo();
        $st = $pdo->prepare("UPDATE jobs SET status=:s WHERE id=:id AND author_id=:a AND deleted_at IS NULL");
        $st->execute(['s'=>$status,'id'=>$id,'a'=>$authorId]);
    }

    public function softDelete(int $id): void
    {
        $pdo = Database::pdo();
        $st = $pdo->prepare("UPDATE jobs SET deleted_at = NOW() WHERE id=:id");
        $st->execute(['id'=>$id]);
    }

    public function listByAuthor(int $authorId): array
    {
        $pdo = Database::pdo();
        $st = $pdo->prepare("SELECT * FROM jobs WHERE author_id=:a AND deleted_at IS NULL ORDER BY created_at DESC");
        $st->execute(['a'=>$authorId]);
        return $st->fetchAll();
    }

    public function listAll(): array
    {
        $pdo = Database::pdo();
        return $pdo->query("SELECT j.*, u.name AS author_name FROM jobs j JOIN users u ON u.id=j.author_id ORDER BY j.created_at DESC")->fetchAll();
    }
}
