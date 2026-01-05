<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>

    <!-- Template Business Casual -->
    <link href="<?= base_url('startbootstrap-business-casual-gh-pages/css/styles.css') ?>" rel="stylesheet">
</head>

<body>

<header class="site-header py-4 text-center">
    <h1 class="site-heading text-center text-faded d-none d-lg-block">
        <span class="site-heading-upper text-primary mb-3">Nom de l’hôtel</span>
        <span class="site-heading-lower">Business Casual</span>
    </h1>

    <?php $segment = service('uri')->getSegment(1); ?>
    <?php if ($segment !== 'Connexion'): ?>
        <nav class="navbar navbar-expand-lg navbar-dark py-lg-4" id="mainNav">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive">
                    Menu
                </button>

                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav mx-auto">
                        <?php if (isset($iduser) && isset($userAdmin) && $userAdmin == 1): ?>
                            <li class="nav-item px-lg-4">
                                <?= anchor('PageAdmin', 'Admin', 'class="nav-link text-uppercase"') ?>
                            </li>
                        <?php else: ?>
                            <li class="nav-item px-lg-4">
                                <?= anchor('Home', 'Accueil', 'class="nav-link text-uppercase"') ?>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    <?php endif; ?>
</header>
