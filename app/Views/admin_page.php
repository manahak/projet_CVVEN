<?= view('templates/header') ?>

<div class="container mt-4">
    <h2>Page d'administration</h2>
    <p>Bienvenue dans l'espace administrateur. Ici vous pouvez gérer les chambres et les réservations.</p>

    <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title">Actions rapides</h5>
            <ul>
                <li><a href="<?= site_url('PageAdmin/chambres') ?>">Gérer les chambres (placeholder)</a></li>
                <li><a href="<?= site_url('PageAdmin/reservations') ?>">Voir les réservations (placeholder)</a></li>
            </ul>
        </div>
    </div>
</div>

<?= view('templates/footer') ?>
