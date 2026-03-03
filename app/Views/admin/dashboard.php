<?php use App\Core\Auth; ?>
<h1 class="h4 mb-3">Admin</h1>

<div class="row g-3">
  <div class="col-lg-6">
    <div class="ff-card bg-white p-4">
      <h2 class="h6 mb-3">Usuários</h2>
      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr>
              <th>ID</th><th>Nome</th><th>E-mail</th><th>Perfil</th><th>Admin</th><th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $u): ?>
              <tr>
                <td><?= (int)$u['id'] ?></td>
                <td><?= e($u['name']) ?></td>
                <td><?= e($u['email']) ?></td>
                <td><?= e($u['primary_role']) ?></td>
                <td><?= ((int)$u['is_admin']===1) ? 'Sim' : 'Não' ?></td>
                <td class="text-end">
                  <?php if ((int)$u['id'] !== (int)Auth::userId()): ?>
                    <form method="post" action="/admin/users/delete" class="d-inline">
                      <input type="hidden" name="_csrf" value="<?= e(Auth::csrfToken()) ?>">
                      <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
                      <button class="btn btn-sm btn-outline-danger" type="submit"
                        onclick="return confirm('Remover usuário?')">Remover</button>
                    </form>
                  <?php else: ?>
                    <span class="small-muted">você</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="ff-card bg-white p-4">
      <h2 class="h6 mb-3">Vagas</h2>
      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr>
              <th>ID</th><th>Título</th><th>Autor</th><th>Status</th><th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($jobs as $j): ?>
              <tr>
                <td><?= (int)$j['id'] ?></td>
                <td><a href="/jobs/show?id=<?= (int)$j['id'] ?>"><?= e($j['title']) ?></a></td>
                <td><?= e($j['author_name'] ?? '') ?></td>
                <td><?= e($j['status']) ?></td>
                <td class="text-end">
                  <form method="post" action="/admin/jobs/delete" class="d-inline">
                    <input type="hidden" name="_csrf" value="<?= e(Auth::csrfToken()) ?>">
                    <input type="hidden" name="id" value="<?= (int)$j['id'] ?>">
                    <button class="btn btn-sm btn-outline-danger" type="submit"
                      onclick="return confirm('Remover vaga?')">Remover</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
