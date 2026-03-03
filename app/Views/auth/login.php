<?php use App\Core\Auth; ?>
<div class="row justify-content-center">
  <div class="col-md-6 col-lg-5">
    <div class="ff-card bg-white p-4">
      <h1 class="h4 mb-3">Entrar</h1>
      <form method="post" action="/auth/login">
        <input type="hidden" name="_csrf" value="<?= e(Auth::csrfToken()) ?>">
        <div class="mb-3">
          <label class="form-label">E-mail</label>
          <input class="form-control ff-input" type="email" name="email" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Senha</label>
          <input class="form-control ff-input" type="password" name="password" required>
        </div>
        <button class="btn ff-btn-primary w-100" type="submit">Entrar</button>
      </form>
      <div class="mt-3 small-muted">
        Não tem conta? <a href="/auth/register">Cadastre-se</a>
      </div>
    </div>
  </div>
</div>
