<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\{Auth, Controller, Flash};
use App\Repositories\{UserRepository, JobRepository};
use App\Services\AdminService;

final class AdminController extends Controller
{
    public function dashboard(): void
    {
        Auth::requireAdmin();
        $users = (new UserRepository())->listAll();
        $jobs = (new JobRepository())->listAll();
        $this->render('admin/dashboard', ['users'=>$users, 'jobs'=>$jobs]);
    }

    public function deleteUser(): void
    {
        Auth::requireAdmin();
        $this->requirePost();
        $this->requireCsrf();

        $id = (int)($_POST['id'] ?? 0);
        (new AdminService(new UserRepository(), new JobRepository()))->deleteUser($id);
        Flash::success('Usuário removido.');
        $this->redirect('/admin');
    }

    public function deleteJob(): void
    {
        Auth::requireAdmin();
        $this->requirePost();
        $this->requireCsrf();

        $id = (int)($_POST['id'] ?? 0);
        (new AdminService(new UserRepository(), new JobRepository()))->deleteJob($id);
        Flash::success('Vaga removida.');
        $this->redirect('/admin');
    }
}
