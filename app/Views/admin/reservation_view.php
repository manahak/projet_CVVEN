<?php echo view('templates/header'); ?>

<div class="container mt-4">
    <h2>Détails de la réservation</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>Numéro :</strong> <?= esc($r['res_num'] ?? '') ?></p>
            <p><strong>Client :</strong> <?= esc(($r['cl_nom'] ?? '') . ' ' . ($r['cl_prenom'] ?? '')) ?></p>
            <p><strong>Email :</strong> <?= esc($r['cl_mail'] ?? '') ?></p>
            <p><strong>Chambre :</strong> <?= esc($r['Id_Chambre'] ?? $r['ch_nom'] ?? '') ?></p>
            <p><strong>Début :</strong> <?= esc($r['res_date_debut'] ?? '') ?></p>
            <p><strong>Fin :</strong> <?= esc($r['res_date_fin'] ?? '') ?></p>
            <p><strong>Durée :</strong> <?= esc($r['res_duree'] ?? '') ?> nuit(s)</p>
            <p><strong>Montant :</strong> <?= esc($r['res_montant'] ?? '') ?> €</p>
            <p><strong>Date de création :</strong> <?= esc($r['res_date'] ?? '') ?></p>
        </div>
    </div>

    <div class="mt-3">
        <a href="<?= site_url('PageAdmin/reservations') ?>" class="btn btn-secondary">Retour</a>
        <form method="post" action="<?= site_url('PageAdmin/reservationCancel/' . ($r['res_num'] ?? '')) ?>" style="display:inline;" onsubmit="return confirm('Annuler cette réservation ?');">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-danger">Annuler la réservation</button>
        </form>
    </div>
</div>

<?php echo view('templates/footer'); ?>
