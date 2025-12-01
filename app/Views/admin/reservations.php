<?php echo view('templates/header'); ?>

<div class="container mt-4">
    <h2>Voir les réservations</h2>
    <p class="text-muted">Liste des réservations récentes.</p>

    <div class="mb-3">
        <a href="<?= site_url('PageAdmin') ?>" class="btn btn-secondary">Retour</a>
    </div>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Res #</th>
                <th>Client</th>
                <th>Email</th>
                <th>Chambre</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Montant</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($reservations)) : ?>
                <?php foreach ($reservations as $r) : ?>
                    <tr>
                        <td><?= esc($r['res_num'] ?? $r['res_numero'] ?? '') ?></td>
                        <td><?= esc(($r['cl_nom'] ?? '') . ' ' . ($r['cl_prenom'] ?? '')) ?></td>
                        <td><?= esc($r['cl_mail'] ?? '') ?></td>
                        <td><?= esc($r['ch_nom'] ?? $r['Id_Chambre'] ?? '') ?></td>
                        <td><?= esc($r['res_date_debut'] ?? '') ?></td>
                        <td><?= esc($r['res_date_fin'] ?? '') ?></td>
                        <td><?= esc($r['res_montant'] ?? '') ?> €</td>
                        <td>
                            <a href="<?= site_url('PageAdmin/reservationView/' . ($r['res_num'] ?? '')) ?>" class="btn btn-sm btn-info">Voir</a>
                            <form method="post" action="<?= site_url('PageAdmin/reservationCancel/' . ($r['res_num'] ?? '')) ?>" style="display:inline;" onsubmit="return confirm('Annuler cette réservation ?');">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-danger">Annuler</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr><td colspan="8" class="text-center">Aucune réservation trouvée.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php echo view('templates/footer'); ?>
