<title><?= $title ?? '' ?></title>
<link rel="icon" href="<?= Application::get()->toURL("/core/assets/favicon.png") ?>" sizes="32x32" type="image/png">

<?php
/** @var $resourceManager ResourceManager */
include Application::get()->toRoot('/core/ui/views/system/head_required.php');
include Application::get()->toRoot('/core/ui/views/system/scripts_required.php');

$resourceManager->addJavaScript('/core/assets/js/scripts/form.js');
$resourceManager->addJavaScript('/core/assets/js/scripts/confirmation.js');
$resourceManager->addJavaScript('/core/assets/js/scripts/table.js');

$resourceManager->scripts();
$resourceManager->css();
?>
