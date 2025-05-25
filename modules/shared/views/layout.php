<?php $viewEngine->setLayout('_root'); ?>

<main class="d-flex flex-nowrap min-vh-100">
    <?= $viewEngine->renderPartial('sidebar-menu') ?>

    <div class="d-flex flex-column flex-fill">
        <?= $content ?>

    </div>
</main>
