<?php echo view('templates/header'); ?>

<div class="container mt-4">
    <h2><?= (isset($mode) && $mode === 'add') ? 'Ajouter un utilisateur' : 'Modifier l\'utilisateur' ?></h2>

    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $e) : ?>
                    <li><?= esc($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= (isset($mode) && $mode === 'add') ? site_url('PageAdmin/usersAdd') : site_url('PageAdmin/usersEdit/' . ($user['id'] ?? '')) ?>">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" value="<?= esc($user['nom'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Prénom</label>
            <input type="text" name="prenom" class="form-control" value="<?= esc($user['prenom'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= esc($user['email'] ?? '') ?>">
        </div>

        <?php if (!isset($mode) || $mode === 'add') : ?>
            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" value="">
                <small class="form-text text-muted">Min. 6 caractères</small>
            </div>
        <?php endif; ?>

        <div class="mb-3 form-check">
            <input type="checkbox" name="userAdmin" id="userAdmin" class="form-check-input" <?= !empty($user['userAdmin']) ? 'checked' : '' ?> value="1">
            <label for="userAdmin" class="form-check-label">Administrateur</label>
        </div>

        <button type="submit" class="btn btn-primary"><?= (isset($mode) && $mode === 'add') ? 'Ajouter' : 'Enregistrer' ?></button>
        <a href="<?= site_url('PageAdmin/users') ?>" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<?php echo view('templates/footer'); ?>
