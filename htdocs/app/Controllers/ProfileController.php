<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\{Auth, Controller, Flash};
use App\Helpers\Validator;
use App\Repositories\{UserRepository, JobRepository};

final class ProfileController extends Controller
{
    public function dashboard(): void
    {
        Auth::requireLogin();
        $user = (new UserRepository())->findById(Auth::userId());
        $myJobs = (new JobRepository())->listByAuthor(Auth::userId());

        $this->render('profile/dashboard', ['user'=>$user, 'myJobs'=>$myJobs]);
    }

    public function editForm(): void
    {
        Auth::requireLogin();
        $user = (new UserRepository())->findById(Auth::userId());
        $this->render('profile/edit', ['user'=>$user]);
    }

    public function update(): void
    {
        Auth::requireLogin();
        $this->requirePost();
        $this->requireCsrf();

        $errors = Validator::required(['name'], $_POST);
        $name = trim((string)($_POST['name'] ?? ''));
        $bio = trim((string)($_POST['bio'] ?? ''));

        if ($errors) {
            Flash::error('Informe seu nome.');
            $this->redirect('/profile/edit');
        }

        (new UserRepository())->updateProfile(Auth::userId(), $name, $bio);
        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['bio'] = $bio;

        Flash::success('Perfil atualizado.');
        $this->redirect('/profile');
    }

    public function delete(): void
    {
        Auth::requireLogin();
        $this->requirePost();
        $this->requireCsrf();

        $userId = Auth::userId();

        (new UserRepository())->softDelete($userId);

        session_destroy();
        session_start();

        Flash::success('Sua conta foi excluída com sucesso.');
        $this->redirect('/');
    }
}
