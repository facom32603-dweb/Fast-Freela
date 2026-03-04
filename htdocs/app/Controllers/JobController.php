<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\{Auth, Controller, Flash, View};
use App\Helpers\Validator;
use App\Repositories\{JobRepository, FavoriteRepository, CommentRepository};
use App\Services\JobService;

final class JobController extends Controller
{
    public function index(): void
    {
        $q = trim((string)($_GET['q'] ?? ''));
        $jobs = (new JobRepository())->listOpen($q);
        $this->render('jobs/index', ['jobs' => $jobs, 'q' => $q]);
    }

    public function search(): void
    {
        $q = trim((string)($_GET['q'] ?? ''));
        $jobs = (new JobRepository())->listOpen($q);

        ob_start();
        View::includeView('jobs/_list', ['jobs' => $jobs]);
        $html = ob_get_clean();

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['count' => count($jobs), 'html' => $html]);
        exit;
    }

    public function show(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $job = (new JobRepository())->find($id);
        if (!$job) {
            http_response_code(404);
            $this->render('home/404', []);
            return;
        }

        $comments = (new CommentRepository())->listForJob($id);
        $isFav = false;
        if (Auth::check()) {
            $isFav = (new FavoriteRepository())->isFavorited(Auth::userId(), $id);
        }

        $this->render('jobs/show', [
            'job' => $job,
            'comments' => $comments,
            'isFav' => $isFav,
        ]);
    }

    public function createForm(): void
    {
        Auth::requireLogin();
        $this->render('jobs/create', []);
    }

    public function create(): void
    {
        Auth::requireLogin();
        $this->requirePost();
        $this->requireCsrf();

        $errors = Validator::required(['title','description','job_date','estimated_value'], $_POST);
        $title = trim((string)($_POST['title'] ?? ''));
        $description = trim((string)($_POST['description'] ?? ''));
        $jobDate = (string)($_POST['job_date'] ?? '');
        $estimated = (float)($_POST['estimated_value'] ?? 0);
        $details = trim((string)($_POST['hiring_details'] ?? ''));

        if ($errors) {
            Flash::error('Revise os campos e tente novamente.');
            $_SESSION['_form_errors'] = $errors;
            $_SESSION['_form_old'] = $_POST;
            $this->redirect('/jobs/create');
        }

        $id = (new JobRepository())->create(Auth::userId(), $title, $description, $jobDate, $estimated, $details !== '' ? $details : null);
        Flash::success('Vaga publicada!');
        $this->redirect('/jobs/show?id=' . $id);
    }

    public function editForm(): void
    {
        Auth::requireLogin();
        $id = (int)($_GET['id'] ?? 0);
        $job = (new JobRepository())->find($id);
        if (!$job || (int)$job['author_id'] !== Auth::userId()) {
            http_response_code(403);
            $this->render('home/403', []);
            return;
        }
        $this->render('jobs/edit', ['job'=>$job]);
    }

    public function update(): void
    {
        Auth::requireLogin();
        $this->requirePost();
        $this->requireCsrf();

        $id = (int)($_POST['id'] ?? 0);
        $repo = new JobRepository();
        $job = $repo->find($id);
        if (!$job || (int)$job['author_id'] !== Auth::userId()) {
            http_response_code(403);
            $this->render('home/403', []);
            return;
        }

        $errors = Validator::required(['title','description','job_date','estimated_value'], $_POST);
        if ($errors) {
            Flash::error('Revise os campos e tente novamente.');
            $_SESSION['_form_errors'] = $errors;
            $this->redirect('/jobs/edit?id=' . $id);
        }

        $title = trim((string)($_POST['title'] ?? ''));
        $description = trim((string)($_POST['description'] ?? ''));
        $jobDate = (string)($_POST['job_date'] ?? '');
        $estimated = (float)($_POST['estimated_value'] ?? 0);
        $details = trim((string)($_POST['hiring_details'] ?? ''));

        $repo->update($id, Auth::userId(), $title, $description, $jobDate, $estimated, $details !== '' ? $details : null);
        Flash::success('Vaga atualizada.');
        $this->redirect('/jobs/show?id=' . $id);
    }

    public function toggleFavorite(): void
    {
        Auth::requireLogin();
        $this->requirePost();
        $this->requireCsrf();

        $jobId = (int)($_POST['job_id'] ?? 0);
        (new FavoriteRepository())->toggle(Auth::userId(), $jobId);
        $this->redirect('/jobs/show?id=' . $jobId);
    }

    public function favorites(): void
    {
        Auth::requireLogin();
        $jobs = (new FavoriteRepository())->listForUser(Auth::userId());
        $this->render('jobs/favorites', ['jobs'=>$jobs]);
    }

    public function comment(): void
    {
        Auth::requireLogin();
        $this->requirePost();
        $this->requireCsrf();

        $jobId = (int)($_POST['job_id'] ?? 0);
        $content = trim((string)($_POST['content'] ?? ''));

        if ($content === '') {
            Flash::error('Digite um comentário.');
            $this->redirect('/jobs/show?id=' . $jobId);
        }

        (new CommentRepository())->create($jobId, Auth::userId(), $content);
        Flash::success('Comentário enviado!');
        $this->redirect('/jobs/show?id=' . $jobId);
    }

    public function close(): void
    {
        Auth::requireLogin();
        $this->requirePost();
        $this->requireCsrf();

        $jobId = (int)($_POST['job_id'] ?? 0);
        $job = (new JobRepository())->find($jobId);
        if (!$job || (int)$job['author_id'] !== Auth::userId()) {
            http_response_code(403);
            $this->render('home/403', []);
            return;
        }

        (new JobService(new JobRepository()))->closeJob($jobId, Auth::userId());
        Flash::success('Vaga marcada como fechada.');
        $this->redirect('/jobs/show?id=' . $jobId);
    }

    public function reopen(): void
    {
        Auth::requireLogin();
        $this->requirePost();
        $this->requireCsrf();

        $jobId = (int)($_POST['job_id'] ?? 0);
        $job = (new JobRepository())->find($jobId);
        if (!$job || (int)$job['author_id'] !== Auth::userId()) {
            http_response_code(403);
            $this->render('home/403', []);
            return;
        }

        (new JobService(new JobRepository()))->reopenJob($jobId, Auth::userId());
        Flash::success('Vaga reaberta.');
        $this->redirect('/jobs/show?id=' . $jobId);
    }
}
