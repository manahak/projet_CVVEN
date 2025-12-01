<!-- Global header banner visible on all pages -->
<header style="background:#e9ecef; padding:12px 16px; border-bottom:1px solid #d0d0d0;">
    <div style="max-width:1100px; margin:0 auto; display:flex; align-items:center; justify-content:space-between;">
        <div style="font-weight:700; font-size:1.15rem; color:#333;">nom hôtel</div>
        <?php // Don't show nav buttons on the authentication page ?>
        <?php $segment = service('uri')->getSegment(1); ?>
        <?php if ($segment !== 'Connexion'): ?>
        <nav>
            <?php if (isset($iduser) && isset($userAdmin) && $userAdmin == 1): ?>
                <?= anchor('PageAdmin', 'Admin', 'class="btn btn-sm btn-outline-primary"') ?>
            <?php else: ?>
                <?= anchor('Home', 'Accueil', 'class="btn btn-sm btn-outline-success"') ?>
            <?php endif; ?>
        </nav>
        <?php endif; ?>
    </div>
</header>

