<?php use App\Core\Auth; ?>
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="ff-card bg-white p-4">
      <h1 class="h4 mb-3">Editar vaga</h1>

      <form method="post" action="/jobs/update">
        <input type="hidden" name="_csrf" value="<?= e(Auth::csrfToken()) ?>">
        <input type="hidden" name="id" value="<?= (int)$job['id'] ?>">

        <div class="mb-3">
          <label class="form-label">Título</label>
          <input class="form-control ff-input" name="title" value="<?= e($job['title']) ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Descrição</label>
          <textarea class="form-control ff-input" name="description" rows="6" required><?= e($job['description']) ?></textarea>
        </div>

        <div class="row g-2">
          <div class="col-md-6 mb-3">
            <label class="form-label">Data</label>
            <input class="form-control ff-input" type="date" name="job_date" value="<?= e($job['job_date']) ?>" required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Valor estimado (R$)</label>
            <input class="form-control ff-input" type="number" step="0.01" min="0" name="estimated_value" value="<?= e((string)$job['estimated_value']) ?>" required>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Detalhes para contratação</label>
          <textarea class="form-control ff-input" name="hiring_details" rows="3"><?= e($job['hiring_details'] ?? '') ?></textarea>
        </div>

        <div class="d-flex gap-2">
          <button class="btn ff-btn-primary" type="submit">Salvar</button>
          <a class="btn btn-outline-dark" href="/jobs/show?id=<?= (int)$job['id'] ?>">Voltar</a>
        </div>
      </form>
    </div>
  </div>
</div>
