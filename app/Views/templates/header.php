<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
/* Global small adjustments */
body { background-color: #c7c7c7ff; }
.site-header { background: #ffffff; border-bottom: 1px solid #e9ecef; }
.brand { font-weight:700; font-size:1.25rem; color:#212529; }
.room-card { aspect-ratio: 1 / 1; display:flex; flex-direction:column; }
.room-card .card-body { display:flex; flex-direction:column; justify-content:space-between; }
</style>

<header class="site-header py-2">
    <div class="container d-flex flex-column align-items-center text-center">
        <div class="brand">nom hôtel</div>
        <?php // Don't show nav buttons on the authentication page ?>
        <?php $segment = service('uri')->getSegment(1); ?>
        <?php if ($segment !== 'Connexion'): ?>
            <nav class="mt-2">
                <?php if (isset($iduser) && isset($userAdmin) && $userAdmin == 1): ?>
                    <?= anchor('PageAdmin', 'Admin', 'class="btn btn-sm btn-outline-primary mx-1"') ?>
                <?php else: ?>
                    <?= anchor('Home', 'Accueil', 'class="btn btn-sm btn-outline-success mx-1"') ?>
                <?php endif; ?>
            </nav>
        <?php endif; ?>
    </div>
</header>

