<?php echo view('templates/header'); ?>

<div class="container mt-4">
    <h2>Gérer les utilisateurs</h2>
    <p class="text-muted">Liste des comptes utilisateurs. Vous pouvez modifier les rôles ou supprimer un utilisateur.</p>

    <div class="mb-3">
        <a href="<?= site_url('PageAdmin') ?>" class="btn btn-secondary">Retour</a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Admin</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)) : ?>
                <?php foreach ($users as $u) : ?>
                    <tr>
                        <td><?= esc($u['id'] ?? $u['user_id'] ?? '') ?></td>
                        <td><?= esc(($u['nom'] ?? $u['name'] ?? '') . ' ' . ($u['prenom'] ?? '')) ?></td>
                        <td><?= esc($u['email'] ?? $u['mail'] ?? '') ?></td>
                        <td><?= !empty($u['userAdmin']) || !empty($u['is_admin']) ? 'Oui' : 'Non' ?></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning">Modifier</a>
                            <a href="#" class="btn btn-sm btn-danger">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr><td colspan="5" class="text-center">Aucun utilisateur trouvé.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php echo view('templates/footer'); ?>
