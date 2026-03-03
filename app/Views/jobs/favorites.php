<h1 class="h4 mb-3">Meus favoritos</h1>

<?php if (empty($jobs)): ?>
  <div class="ff-card bg-white p-4">
    <div class="fw-semibold">Nenhum favorito ainda</div>
    <div class="small-muted">Abra uma vaga e clique em “Favoritar”.</div>
  </div>
<?php else: ?>
  <?php \App\Core\View::includeView('jobs/_list', ['jobs'=>$jobs]); ?>
<?php endif; ?>
