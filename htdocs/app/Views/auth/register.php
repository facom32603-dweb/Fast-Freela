<?php
use App\Core\Auth;

$errors = $_SESSION['_form_errors'] ?? [];
$old = $_SESSION['_form_old'] ?? [];
unset($_SESSION['_form_errors'], $_SESSION['_form_old']);
?>
<div class="row justify-content-center">
  <div class="col-md-7 col-lg-6">
    <div class="ff-card bg-white p-4">
      <h1 class="h4 mb-3">Criar conta</h1>

      <form method="post" action="/auth/register">
        <input type="hidden" name="_csrf" value="<?= e(Auth::csrfToken()) ?>">

        <div class="mb-3">
          <label class="form-label">Nome</label>
          <input class="form-control ff-input" name="name" value="<?= e($old['name'] ?? '') ?>" required>
          <?php if (isset($errors['name'])): ?><div class="text-danger small"><?= e($errors['name']) ?></div><?php endif; ?>
        </div>

        <div class="mb-3">
          <label class="form-label">E-mail</label>
          <input class="form-control ff-input" type="email" name="email" value="<?= e($old['email'] ?? '') ?>" required>
          <?php if (isset($errors['email'])): ?><div class="text-danger small"><?= e($errors['email']) ?></div><?php endif; ?>
        </div>

        <div class="mb-3">
          <label class="form-label">Senha</label>
          <input class="form-control ff-input" type="password" name="password" required>
          <?php if (isset($errors['password'])): ?><div class="text-danger small"><?= e($errors['password']) ?></div><?php endif; ?>
        </div>

        <div class="mb-3">
          <label class="form-label">Perfil</label>
          <select class="form-select ff-input" name="role" required>
            <option value="WORKER" <?= (($old['role'] ?? '') === 'WORKER') ? 'selected' : '' ?>>Trabalhador</option>
            <option value="CONTRACTOR" <?= (($old['role'] ?? '') === 'CONTRACTOR') ? 'selected' : '' ?>>Contratante</option>
          </select>
          <?php if (isset($errors['role'])): ?><div class="text-danger small"><?= e($errors['role']) ?></div><?php endif; ?>
        </div>

        <button class="btn ff-btn-primary w-100" type="submit">Cadastrar</button>
      </form>

      <div class="mt-3 small-muted">
        Já tem conta? <a href="/auth/login">Entrar</a>
      </div>
    </div>
  </div>
</div>
