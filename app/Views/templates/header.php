<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* Custom color palette */
:root {
    --color-primary: #0D3428;
    --color-secondary: #6E8E88;
    --color-light: #FAF2E1;
    --color-accent: #710019;
}

/* Global adjustments */
body { background-color: var(--color-light); }
.site-header { background: var(--color-primary); border-bottom: 2px solid var(--color-secondary); }
.brand { font-weight:700; font-size:1.25rem; color: var(--color-light); }

/* Override Bootstrap button colors */
.btn-primary, .btn-outline-primary { 
    background-color: var(--color-primary) !important; 
    border-color: var(--color-primary) !important; 
    color: var(--color-light) !important;
}
.btn-primary:hover, .btn-outline-primary:hover { 
    background-color: var(--color-accent) !important; 
    border-color: var(--color-accent) !important;
}

.btn-success, .btn-outline-success { 
    background-color: var(--color-secondary) !important; 
    border-color: var(--color-secondary) !important; 
    color: var(--color-light) !important;
}
.btn-success:hover, .btn-outline-success:hover { 
    background-color: var(--color-primary) !important; 
    border-color: var(--color-primary) !important;
}

/* Card styling with custom colors */
.card { border-color: var(--color-secondary); }
.card-header { background-color: var(--color-primary); color: var(--color-light); }

.room-card { aspect-ratio: 1 / 1; display:flex; flex-direction:column; }
.room-card .card-body { display:flex; flex-direction:column; justify-content:space-between; }

/* Navigation link colors */
a { color: var(--color-accent); text-decoration: none; }
a:hover { color: var(--color-primary); text-decoration: underline; }

/* Form elements */
.form-control:focus { border-color: var(--color-secondary); box-shadow: 0 0 0 0.2rem rgba(110, 142, 136, 0.25); }

/* Alerts styling */
.alert-success { background-color: var(--color-secondary); border-color: var(--color-primary); color: white; }
.alert-danger { background-color: var(--color-accent); border-color: #4a0010; color: white; }
.alert-info { background-color: var(--color-primary); border-color: var(--color-secondary); color: white; }
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

