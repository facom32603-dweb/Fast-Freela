<?php
use App\Core\Auth;

$errors = $_SESSION['_form_errors'] ?? [];
$old = $_SESSION['_form_old'] ?? [];
unset($_SESSION['_form_errors'], $_SESSION['_form_old']);
?>
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="ff-card bg-white p-4">
      <h1 class="h4 mb-3">Publicar vaga</h1>

      <form method="post" action="/jobs/create">
        <input type="hidden" name="_csrf" value="<?= e(Auth::csrfToken()) ?>">

        <div class="mb-3">
          <label class="form-label">Título</label>
          <input class="form-control ff-input" name="title" value="<?= e($old['title'] ?? '') ?>" required>
          <?php if (isset($errors['title'])): ?><div class="text-danger small"><?= e($errors['title']) ?></div><?php endif; ?>
        </div>

        <div class="mb-3">
          <label class="form-label">Descrição</label>
          <textarea class="form-control ff-input" name="description" rows="6" required><?= e($old['description'] ?? '') ?></textarea>
          <?php if (isset($errors['description'])): ?><div class="text-danger small"><?= e($errors['description']) ?></div><?php endif; ?>
        </div>

        <div class="row g-2">
          <div class="col-md-6 mb-3">
            <label class="form-label">📅 Data</label>
            <input class="form-control ff-input" type="date" name="job_date" value="<?= e($old['job_date'] ?? date('Y-m-d')) ?>" required>
            <?php if (isset($errors['job_date'])): ?><div class="text-danger small"><?= e($errors['job_date']) ?></div><?php endif; ?>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">💵 Valor estimado (R$)</label>
            <input class="form-control ff-input" type="number" step="0.01" min="0" name="estimated_value" value="<?= e($old['estimated_value'] ?? '0.00') ?>" required>
            <?php if (isset($errors['estimated_value'])): ?><div class="text-danger small"><?= e($errors['estimated_value']) ?></div><?php endif; ?>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">📌 Detalhes para contratação (visível somente para logados)</label>
          <textarea class="form-control ff-input" name="hiring_details" rows="3"><?= e($old['hiring_details'] ?? '') ?></textarea>
        </div>

        <div class="d-flex gap-2">
          <button class="btn ff-btn-primary" type="submit">Publicar</button>
          <a class="btn btn-outline-dark" href="/jobs">Cancelar</a>
        </div>
      </form>
    </div>
  </div>
</div>
