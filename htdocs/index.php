<?php

declare(strict_types=1);

require_once __DIR__ . '/app/bootstrap.php';

use App\Core\Router;

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\JobController;
use App\Controllers\ProfileController;
use App\Controllers\AdminController;

$router = new Router();

// Home
$router->get('/', fn() => (new HomeController())->index());

// Auth
$router->get('/auth/login', fn() => (new AuthController())->showLogin());
$router->post('/auth/login', fn() => (new AuthController())->login());
$router->get('/auth/register', fn() => (new AuthController())->showRegister());
$router->post('/auth/register', fn() => (new AuthController())->register());
$router->get('/auth/logout', fn() => (new AuthController())->logout());

// Jobs
$router->get('/jobs', fn() => (new JobController())->index());
$router->get('/jobs/search', fn() => (new JobController())->search());
$router->get('/jobs/show', fn() => (new JobController())->show());
$router->get('/jobs/create', fn() => (new JobController())->createForm());
$router->post('/jobs/create', fn() => (new JobController())->create());
$router->get('/jobs/edit', fn() => (new JobController())->editForm());
$router->post('/jobs/update', fn() => (new JobController())->update());
$router->post('/jobs/favorite', fn() => (new JobController())->toggleFavorite());
$router->get('/jobs/favorites', fn() => (new JobController())->favorites());
$router->post('/jobs/comment', fn() => (new JobController())->comment());
$router->post('/jobs/close', fn() => (new JobController())->close());
$router->post('/jobs/reopen', fn() => (new JobController())->reopen());

// Profile
$router->get('/profile', fn() => (new ProfileController())->dashboard());
$router->get('/profile/edit', fn() => (new ProfileController())->editForm());
$router->post('/profile/update', fn() => (new ProfileController())->update());

// Admin
$router->get('/admin', fn() => (new AdminController())->dashboard());
$router->post('/admin/users/delete', fn() => (new AdminController())->deleteUser());
$router->post('/admin/jobs/delete', fn() => (new AdminController())->deleteJob());

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
