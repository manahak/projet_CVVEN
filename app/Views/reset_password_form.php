<?php echo view('templates/header'); ?>

<div class="container my-5">
    <h3 class="mb-4">Réinitialiser le mot de passe</h3>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('Connexion/resetPassword') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="email" value="<?= esc($email) ?>">

        <div class="mb-3">
            <label class="form-label">Nouveau mot de passe</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Confirmer le mot de passe</label>
            <input type="password" name="password_confirm" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="<?= site_url('Connexion') ?>" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<?php echo view('templates/footer'); ?>
