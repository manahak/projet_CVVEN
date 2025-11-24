<?php if (isset($iduser) && $userAdmin == 1): ?>
    <?= anchor('PageAdmin', '', 'class="nav-link fa fa-home fa-2x text-primary"') ?>
<?php else: ?>
    <?= anchor('Home', '', 'class="nav-link fa fa-home fa-2x text-success"') ?>
<?php endif; ?>
