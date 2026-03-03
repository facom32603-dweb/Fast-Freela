<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\{Auth, Controller, Flash};
use App\Helpers\Validator;
use App\Repositories\UserRepository;
use App\Services\AuthService;

final class AuthController extends Controller
{
    public function showLogin(): void
    {
        $this->render('auth/login', []);
    }

    public function login(): void
    {
        $this->requirePost();
        $this->requireCsrf();

        $email = trim((string)($_POST['email'] ?? ''));
        $password = (string)($_POST['password'] ?? '');

        if ($email === '' || $password === '') {
            Flash::error('Preencha e-mail e senha.');
            $this->redirect('/auth/login');
        }

        $service = new AuthService(new UserRepository());
        $user = $service->login($email, $password);

        if (!$user) {
            Flash::error('E-mail ou senha inválidos.');
            $this->redirect('/auth/login');
        }

        $_SESSION['user'] = $user;
        Flash::success('Login realizado com sucesso.');
        $this->redirect('/jobs');
    }

    public function showRegister(): void
    {
        $this->render('auth/register', []);
    }

    public function register(): void
    {
        $this->requirePost();
        $this->requireCsrf();

        $errors = Validator::required(['name','email','password','role'], $_POST);
        $name = trim((string)($_POST['name'] ?? ''));
        $email = trim((string)($_POST['email'] ?? ''));
        $password = (string)($_POST['password'] ?? '');
        $role = (string)($_POST['role'] ?? 'WORKER');

        if ($email !== '' && !Validator::email($email)) $errors['email'] = 'E-mail inválido.';
        if ($password !== '' && strlen($password) < 6) $errors['password'] = 'A senha deve ter ao menos 6 caracteres.';
        if (!in_array($role, ['CONTRACTOR','WORKER'], true)) $errors['role'] = 'Perfil inválido.';

        if ($errors) {
            Flash::error('Revise os campos e tente novamente.');
            $_SESSION['_form_errors'] = $errors;
            $_SESSION['_form_old'] = ['name'=>$name,'email'=>$email,'role'=>$role];
            $this->redirect('/auth/register');
        }

        $repo = new UserRepository();
        if ($repo->findByEmail($email)) {
            Flash::error('Este e-mail já está cadastrado.');
            $this->redirect('/auth/register');
        }

        $id = $repo->create($name, $email, password_hash($password, PASSWORD_DEFAULT), $role);
        $_SESSION['user'] = [
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'primary_role' => $role,
            'is_admin' => false,
        ];

        Flash::success('Conta criada! Bem-vindo(a).');
        $this->redirect('/jobs');
    }

    public function logout(): void
    {
        session_destroy();
        session_start();
        Flash::info('Você saiu da sua conta.');
        $this->redirect('/');
    }
}
