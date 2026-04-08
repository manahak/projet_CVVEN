<?php echo view('templates/header'); ?>

<div class="container my-5">
    <h3 class="mb-4">Mot de passe oublié</h3>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('Connexion/askSecurity') ?>">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label class="form-label">Votre adresse email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Suivant</button>
        <a href="<?= site_url('Connexion') ?>" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<?php echo view('templates/footer'); ?>
