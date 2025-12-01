<?= view('templates/header') ?>

<h3 class="text-center mb-4">Créer un compte</h3>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<form action="<?= site_url('Inscription/register') ?>" method="post">
    <div class="mb-3">
        <label>Nom</label>
        <input type="text" name="cl_nom" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Prénom</label>
        <input type="text" name="cl_prenom" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="cl_mail" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Mot de passe</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success w-100">S’inscrire</button>
</form>

<div class="mt-3 text-center">
    <a href="<?= site_url('Connexion') ?>">Retour à la connexion</a>
</div>
