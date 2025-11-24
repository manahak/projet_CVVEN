<!doctype html>
<html lang="fr">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= isset($title) ? esc($title) . ' - ' : '' ?>CVVEN</title>
        <!-- Bootstrap CSS (CDN) -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ENjdO4Dr2bkBIFxQpeoYz1H/2Q1p0hK9QZQ5q5r5mQmZt5a1qV1QvZ6jIW3" crossorigin="anonymous">
        <!-- Optional site-wide CSS -->
        <?php if (isset($styles) && is_array($styles)): ?>
                <?php foreach ($styles as $s): ?>
                        <link rel="stylesheet" href="<?= esc($s) ?>">
                <?php endforeach; ?>
        <?php endif; ?>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand" href="<?= site_url() ?>">CVVEN</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <?php if (isset($iduser) && ($userAdmin ?? 0) == 1): ?>
                    <li class="nav-item"><a class="nav-link text-primary" href="<?= site_url('PageAdmin') ?>">Admin</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link text-success" href="<?= site_url('Home') ?>">Accueil</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
