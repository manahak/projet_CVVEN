<?php echo view('templates/header'); ?>

<div class="container mt-4">
    <h2><?= ($mode === 'edit') ? 'Modifier la chambre' : 'Ajouter une chambre' ?></h2>

    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $e) : ?>
                    <li><?= esc($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= ($mode === 'edit') ? site_url('PageAdmin/chambresEdit/' . ($chambre['Id_Chambre'] ?? $chambre['id'] ?? '')) : site_url('PageAdmin/chambresAdd') ?>">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label">Numéro</label>
            <input type="text" name="ch_numero" class="form-control" value="<?= esc($chambre['ch_numero'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Capacité</label>
            <input type="number" name="ch_capacite" class="form-control" value="<?= esc($chambre['ch_capacite'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Prix (€)</label>
            <input type="text" name="ch_prix" class="form-control" value="<?= esc($chambre['ch_prix'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Nom de la chambre</label>
            <textarea name="ch_description" class="form-control"><?= esc($chambre['ch_description'] ?? '') ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary"><?= ($mode === 'edit') ? 'Enregistrer' : 'Ajouter' ?></button>
        <a href="<?= site_url('PageAdmin/chambres') ?>" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<?php echo view('templates/footer'); ?>
