<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\JobRepository;

final class AdminService
{
    public function __construct(
        private UserRepository $users,
        private JobRepository $jobs
    ) {}

    public function deleteUser(int $id): void { $this->users->softDelete($id); }
    public function deleteJob(int $id): void { $this->jobs->softDelete($id); }
}
