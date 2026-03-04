<?php
use App\Core\Auth;
use App\Core\Flash;
use App\Core\View;

$flash = Flash::pull();
$authUser = Auth::user();

?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>FastFreela</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/css/app.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1100">
  <?php if ($flash): ?>
    <div class="alert alert-<?= e($flash['type']) ?> ff-card shadow" data-flash-autohide="1" role="alert">
      <?= e($flash['message']) ?>
    </div>
  <?php endif; ?>
</div>

<nav class="navbar navbar-expand-lg ff-navbar">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="/">
      <img src="/assets/img/logo.svg" alt="FastFreela" width="28" height="28" onerror="this.style.display='none'">
      <strong>FastFreela</strong>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navFF">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div id="navFF" class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="/jobs">Vagas</a></li>
        <?php if (Auth::check()): ?>
          <li class="nav-item"><a class="nav-link" href="/jobs/favorites">Favoritos</a></li>
          <li class="nav-item"><a class="nav-link" href="/profile">Minha área</a></li>
        <?php endif; ?>
        <?php if (Auth::isAdmin()): ?>
          <li class="nav-item"><a class="nav-link" href="/admin">Admin</a></li>
        <?php endif; ?>
      </ul>

      <div class="d-flex gap-2 align-items-center">
        <?php if ($authUser): ?>
          <span class="text-white-50 small">Olá, <?= e($authUser['name']) ?></span>
          <a class="btn btn-sm ff-btn-primary" href="/jobs/create">Publicar</a>
          <form action="/auth/logout" method="POST">
            <input type="hidden" name="_csrf" value="<?= e(Auth::csrfToken()) ?>">
            <button type="submit" class="btn btn-sm btn-outline-light">Sair</button>
          </form>
        <?php else: ?>
          <a class="btn btn-sm btn-outline-light" href="/auth/login">Entrar</a>
          <a class="btn btn-sm ff-btn-primary" href="/auth/register">Criar conta</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<main class="container my-4 flex-grow-1">
  <?php View::includeView($view, get_defined_vars()); ?>
</main>

<footer class="container pb-4 ff-footer">
  <div class="d-flex justify-content-between align-items-center">
    <div>© <?= date('Y') ?> FastFreela</div>
    <div class="small-muted">Feito com PHP + MVC + Bootstrap</div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/app.js"></script>
</body>
</html>
