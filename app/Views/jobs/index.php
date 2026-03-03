<?php use App\Core\Auth; ?>
<div class="d-flex justify-content-between align-items-end mb-3">
  <div>
    <h1 class="h4 mb-1">Vagas</h1>
    <div class="small-muted">Pesquise por palavras no título. A lista atualiza sozinha 😉</div>
  </div>
  <?php if (Auth::check()): ?>
    <a class="btn ff-btn-primary" href="/jobs/create">Publicar vaga</a>
  <?php endif; ?>
</div>

<div class="ff-card bg-white p-3 mb-3">
  <label class="form-label">Buscar</label>
  <input id="jobSearchInput" class="form-control ff-input" placeholder="Ex.: design, landing page, logo..." value="<?= e($q ?? '') ?>">
</div>

<div id="jobsEmpty" class="ff-card bg-white p-4 <?= (count($jobs) > 0) ? 'd-none' : '' ?>">
  <div class="fw-semibold">Nenhuma vaga encontrada</div>
  <div class="small-muted">Tente uma palavra diferente.</div>
</div>

<div id="jobsList">
  <?php \App\Core\View::includeView('jobs/_list', ['jobs'=>$jobs]); ?>
</div>

<script src="/assets/js/jobs-search.js"></script>
