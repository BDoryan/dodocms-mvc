<title><?= $title ?? '' ?></title>
<link rel="icon" href="<?= Application::get()->toURL("/core/assets/favicon.png") ?>" sizes="32x32" type="image/png">
<?php view(Application::get()->toRoot('/core/views/system/head_required.php')); ?>