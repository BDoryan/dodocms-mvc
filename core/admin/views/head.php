<title><?= $title ?? '' ?></title>
<link rel="icon" href="<?= Application::get()->toURL("/core/admin/assets/favicon.png") ?>" sizes="32x32" type="image/png">

<?php view(Application::get()->toRoot('/core/ui/views/system/head_required.php')); ?>

<!-- Only in the back-office -->
<script src="<?= Application::get()->toURL('/core/admin/js/scripts/table.js') ?>"></script>