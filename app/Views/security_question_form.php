<?php echo view('templates/header'); ?>

<div class="container my-5">
    <h3 class="mb-4">Question de sécurité</h3>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <p><strong><?= esc($question) ?></strong></p>

    <form method="post" action="<?= site_url('Connexion/verifySecurity') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="email" value="<?= esc($email) ?>">
        <div class="mb-3">
            <label class="form-label">Réponse</label>
            <input type="text" name="security_answer" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Vérifier</button>
        <a href="<?= site_url('Connexion') ?>" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<?php echo view('templates/footer'); ?>
