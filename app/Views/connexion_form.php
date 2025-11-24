<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm p-4">
            <h3 class="text-center mb-4">Connexion</h3>

            <!-- Message d'erreur si mauvais identifiants -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <!-- Formulaire -->
            <form action="<?= site_url('Connexion/login') ?>" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Adresse électronique</label>
                    <input type="email" name="email" class="form-control" required placeholder="Email">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control" required placeholder="Mot de passe">
                </div>

                <button type="submit" class="btn btn-primary w-100">Se connecter</button>
            </form>

            <div class="mt-3 text-center">
                <a href="<?= site_url('Inscription') ?>" class="btn btn-outline-primary">Créer un compte</a>
            </div>
        </div>
    </div>
</div>


