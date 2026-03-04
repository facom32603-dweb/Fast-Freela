<?php use App\Core\Auth; ?>
<div class="d-flex justify-content-between align-items-end mb-3">
  <div>
    <h1 class="h4 mb-1">Minha área</h1>
    <div class="small-muted">Gerencie seu perfil e suas vagas.</div>
  </div>
  <a class="btn btn-outline-dark" href="/profile/edit">Editar perfil</a>
</div>

<div class="row g-3">
  <div class="col-lg-4">
    <div class="ff-card bg-white p-4">
      <div class="fw-semibold mb-1"><?= e($user['name']) ?></div>
      <div class="small-muted"><?= e($user['email']) ?></div>
      <hr>
      <div class="small-muted">Bio</div>
      <div style="white-space: pre-wrap;"><?= e($user['bio']) ?? 'Sem bio'  ?></div>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="ff-card bg-white p-4">
      <div class="d-flex justify-content-between align-items-center">
        <h2 class="h6 mb-0">Minhas vagas</h2>
        <a class="btn btn-sm ff-btn-primary" href="/jobs/create">Publicar</a>
      </div>
      <hr>
      <?php if (empty($myJobs)): ?>
        <div class="small-muted">Você ainda não publicou vagas.</div>
      <?php else: ?>
        <div class="list-group">
          <?php foreach ($myJobs as $j): ?>
            <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
               href="/jobs/show?id=<?= (int)$j['id'] ?>">
              <div>
                <div class="fw-semibold"><?= e($j['title']) ?></div>
                <div class="small-muted"><?= e($j['job_date']) ?></div>
              </div>
              <span class="badge <?= ($j['status']==='OPEN') ? 'ff-badge-open' : 'ff-badge-closed' ?>">
                <?= ($j['status']==='OPEN') ? 'Aberta' : 'Fechada' ?>
              </span>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
