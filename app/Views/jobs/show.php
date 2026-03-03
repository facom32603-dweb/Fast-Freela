<?php
use App\Core\Auth;
?>
<div class="row g-3">
  <div class="col-lg-8">
    <div class="ff-card bg-white p-4">
      <div class="d-flex justify-content-between align-items-start gap-3">
        <div>
          <h1 class="h4 mb-1"><?= e($job['title']) ?></h1>
          <div class="small-muted">por <?= e($job['author_name']) ?> • <?= e($job['job_date']) ?></div>
        </div>
        <span class="badge <?= ($job['status']==='OPEN') ? 'ff-badge-open' : 'ff-badge-closed' ?>">
          <?= ($job['status']==='OPEN') ? 'Aberta' : 'Fechada' ?>
        </span>
      </div>

      <hr>

      <div class="mb-3">
        <div class="fw-semibold mb-1">Descrição</div>
        <div style="white-space: pre-wrap;"><?= e($job['description']) ?></div>
      </div>

      <div class="row g-2">
        <div class="col-md-6">
          <div class="fw-semibold mb-1">Valor estimado</div>
          <div>R$ <?= e(number_format((float)$job['estimated_value'], 2, ',', '.')) ?></div>
        </div>
        <div class="col-md-6">
          <div class="fw-semibold mb-1">Detalhes para contratação</div>
          <?php if (Auth::check()): ?>
            <div style="white-space: pre-wrap;"><?= e($job['hiring_details'] ?? 'Não informado.') ?></div>
          <?php else: ?>
            <div class="small-muted">Entre para ver os detalhes de contato.</div>
          <?php endif; ?>
        </div>
      </div>

      <?php if (Auth::check()): ?>
        <hr>
        <div class="d-flex gap-2 flex-wrap">
          <form method="post" action="/jobs/favorite">
            <input type="hidden" name="_csrf" value="<?= e(Auth::csrfToken()) ?>">
            <input type="hidden" name="job_id" value="<?= (int)$job['id'] ?>">
            <button class="btn btn-outline-dark" type="submit">
              <?= $isFav ? 'Remover dos favoritos' : 'Favoritar' ?>
            </button>
          </form>

          <?php if ((int)$job['author_id'] === (int)Auth::userId()): ?>
            <a class="btn btn-outline-dark" href="/jobs/edit?id=<?= (int)$job['id'] ?>">Editar</a>

            <?php if ($job['status'] === 'OPEN'): ?>
              <form method="post" action="/jobs/close">
                <input type="hidden" name="_csrf" value="<?= e(Auth::csrfToken()) ?>">
                <input type="hidden" name="job_id" value="<?= (int)$job['id'] ?>">
                <button class="btn ff-btn-primary" type="submit">Marcar como fechada</button>
              </form>
            <?php else: ?>
              <form method="post" action="/jobs/reopen">
                <input type="hidden" name="_csrf" value="<?= e(Auth::csrfToken()) ?>">
                <input type="hidden" name="job_id" value="<?= (int)$job['id'] ?>">
                <button class="btn ff-btn-primary" type="submit">Reabrir</button>
              </form>
            <?php endif; ?>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>

    <div class="ff-card bg-white p-4 mt-3">
      <h2 class="h6 mb-3">Comentários</h2>

      <?php if (Auth::check()): ?>
        <form method="post" action="/jobs/comment" class="mb-3">
          <input type="hidden" name="_csrf" value="<?= e(Auth::csrfToken()) ?>">
          <input type="hidden" name="job_id" value="<?= (int)$job['id'] ?>">
          <textarea class="form-control ff-input" name="content" rows="3" placeholder="Escreva um comentário..."></textarea>
          <div class="mt-2 text-end">
            <button class="btn ff-btn-primary" type="submit">Enviar</button>
          </div>
        </form>
      <?php else: ?>
        <div class="small-muted mb-3">Entre para comentar.</div>
      <?php endif; ?>

      <?php if (empty($comments)): ?>
        <div class="small-muted">Sem comentários ainda.</div>
      <?php else: ?>
        <div class="d-flex flex-column gap-2">
          <?php foreach ($comments as $c): ?>
            <div class="border rounded-3 p-3">
              <div class="d-flex justify-content-between">
                <div class="fw-semibold"><?= e($c['user_name']) ?></div>
                <div class="small-muted"><?= e($c['created_at']) ?></div>
              </div>
              <div style="white-space: pre-wrap;"><?= e($c['content']) ?></div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="ff-card bg-white p-4">
      <div class="fw-semibold mb-1">Ações rápidas</div>
      <div class="small-muted">Voltar para a lista ou ver seus favoritos.</div>
      <div class="d-grid gap-2 mt-3">
        <a class="btn btn-outline-dark" href="/jobs">Voltar</a>
        <?php if (Auth::check()): ?>
          <a class="btn btn-outline-dark" href="/jobs/favorites">Favoritos</a>
        <?php else: ?>
          <a class="btn ff-btn-primary" href="/auth/login">Entrar</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
