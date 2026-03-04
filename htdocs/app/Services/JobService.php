<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\JobRepository;

final class JobService
{
    public function __construct(private JobRepository $jobs) {}

    public function closeJob(int $jobId, int $authorId): void
    {
        $this->jobs->setStatus($jobId, $authorId, 'CLOSED');
    }

    public function reopenJob(int $jobId, int $authorId): void
    {
        $this->jobs->setStatus($jobId, $authorId, 'OPEN');
    }
}
