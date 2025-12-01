<?php echo view('templates/header'); ?>

<div class="container mt-4">
    <h2>Gérer les chambres</h2>
    <p class="text-muted">Liste des chambres disponibles. Cliquer sur "Ajouter" pour créer une nouvelle chambre.</p>

    <div class="mb-3">
        <a href="<?= site_url('PageAdmin/chambresAdd') ?>" class="btn btn-primary">Ajouter une chambre</a>
        <a href="<?= site_url('PageAdmin') ?>" class="btn btn-secondary">Retour</a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Numéro / Nom</th>
                <th>Capacité</th>
                <th>Prix</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($chambres)) : ?>
                <?php foreach ($chambres as $c) : ?>
                    <tr>
                        <td><?= esc($c['Id_Chambre'] ?? $c['id'] ?? '') ?></td>
                        <td><?= esc($c['ch_nom'] ?? $c['numero'] ?? '') ?></td>
                        <td><?= esc($c['ch_capacite'] ?? $c['capacite'] ?? '') ?></td>
                        <td><?= esc($c['ch_prix'] ?? $c['prix'] ?? '') ?> €</td>
                        <td><?= esc($c['ch_description'] ?? $c['description'] ?? '') ?></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-info">Éditer</a>
                            <a href="#" class="btn btn-sm btn-danger">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr><td colspan="6" class="text-center">Aucune chambre trouvée.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php echo view('templates/footer'); ?>
