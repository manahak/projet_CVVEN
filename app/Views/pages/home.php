<h2>Liste des chambres</h2>
<ul class="list-group">
    <?php foreach($chambres as $ch): ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <?= $ch['ch_numero'] ?> - <?= $ch['ch_description'] ?> - <?= $ch['ch_prix'] ?> €
            <a href="<?= site_url('Reservation/form/'.$ch['Id_Chambre']) ?>" class="btn btn-primary btn-sm">Réserver</a>
        </li>
    <?php endforeach; ?>
</ul>
