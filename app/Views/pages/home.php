<?php echo view('templates/header'); ?>

<div class="container my-4">
    <h2 class="mb-4">Liste des chambres</h2>
    <ul class="list-group">
        <?php foreach($chambres as $ch): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?= esc($ch['ch_numero']) ?> - <?= esc($ch['ch_description']) ?> - <?= number_format($ch['ch_prix'], 2, ',', ' ') ?> €
                <a href="<?= site_url('Reservation/form/'.$ch['Id_Chambre']) ?>" class="btn btn-primary btn-sm">Réserver</a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php echo view('templates/footer'); ?>
