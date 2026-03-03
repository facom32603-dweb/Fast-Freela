<?php if (empty($jobs)): return; endif; ?>
<div class="row g-3">
  <?php foreach ($jobs as $job): ?>
    <div class="col-md-6 col-lg-4">
      <div class="ff-card bg-white p-3 h-100">
        <div class="d-flex justify-content-between align-items-start gap-2">
          <div>
            <div class="fw-semibold"><?= e($job['title']) ?></div>
            <div class="small-muted">por <?= e($job['author_name']) ?> • <?= e($job['job_date']) ?></div>
          </div>
          <span class="badge <?= ($job['status']==='OPEN') ? 'ff-badge-open' : 'ff-badge-closed' ?>">
            <?= ($job['status']==='OPEN') ? 'Aberta' : 'Fechada' ?>
          </span>
        </div>

        <div class="mt-2 small-muted">
          <?= e(mb_strimwidth((string)$job['description'], 0, 120, '…', 'UTF-8')) ?>
        </div>

        <div class="mt-3 d-flex justify-content-between align-items-center">
          <div class="fw-semibold">R$ <?= e(number_format((float)$job['estimated_value'], 2, ',', '.')) ?></div>
          <a class="btn btn-sm btn-outline-dark" href="/jobs/show?id=<?= (int)$job['id'] ?>">Ver</a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
