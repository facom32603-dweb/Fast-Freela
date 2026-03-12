<?php use App\Core\Auth; ?>
<div class="row justify-content-center">
  <div class="col-lg-7">
    <div class="ff-card bg-white p-4">
      <h1 class="h4 mb-3">Editar perfil</h1>

      <form method="post" action="/profile/update">
        <input type="hidden" name="_csrf" value="<?= e(Auth::csrfToken()) ?>">

        <div class="mb-3">
          <label class="form-label">Nome</label>
          <input class="form-control ff-input" name="name" value="<?= e($user['name'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Bio</label>
          <textarea class="form-control ff-input" name="bio" rows="5"><?= e($user['bio'] ?? '') ?></textarea>
        </div>

        <div class="d-flex gap-2">
          <button class="btn ff-btn-primary" type="submit">Salvar</button>
          <a class="btn btn-outline-dark" href="/profile">Voltar</a>
        </div>
      </form>
    </div>
        <div class="d-flex justify-content-center mt-4">
            <form method="post" action="/profile/delete" onsubmit="return confirm('Tem certeza que deseja excluir sua conta?')">
                <input type="hidden" name="_csrf" value="<?= e(Auth::csrfToken()) ?>">
                <button class="btn btn-outline-danger" type="submit">Excluir conta</button>
            </form>
        </div>
  </div>
</div>
