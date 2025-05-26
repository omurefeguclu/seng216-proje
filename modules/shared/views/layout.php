<?php setLayout('_root'); ?>

<main class="d-flex flex-nowrap min-vh-100">
    <?= renderPartial('sidebar-menu') ?>

    <div class="d-flex flex-column flex-fill">
        <?= $content ?>

    </div>
</main>
