<h3>Réserver la chambre <?= $chambre['ch_numero'] ?></h3>

<?php if(session()->getFlashdata('error')): ?>
<div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<form action="<?= site_url('Reservation/submit') ?>" method="post">
    <input type="hidden" name="Id_Chambre" value="<?= $chambre['Id_Chambre'] ?>">
    <div class="mb-3">
        <label>Nombre de personnes</label>
        <input type="number" name="res_nb_personnes" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Date début</label>
        <input type="datetime-local" name="res_date_debut" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Date fin</label>
        <input type="datetime-local" name="res_date_fin" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Réserver</button>
</form>
