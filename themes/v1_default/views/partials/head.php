<title><?= $title ?? 'Untitled' ?></title>
<meta name="description" content="<?= $description ?? '' ?>">
<meta name="keywords" content="<?= $keywords ?? '' ?>">
<meta name="author" content="<?= $author ?? '' ?>">
<?php
/** @var ResourceModel $favicon */
if (($favicon ?? null) != null) {
    ?>
    <link rel="shortcut icon" href="<?= $favicon->getSrc() ?? '' ?>"
          type="<?= $favicon->getMimeType() ?? '' ?>">
    <?php
}
?>

<!-- DodoCMS(<?= Application::theme()->getName() ?>) : ResourceManager  -->
<?php
/** @var $themeResourceManager ResourceManager */

$theme = Application::theme();
$themeResourceManager = $theme->getResourceManager();

$themeResourceManager->addCSS('assets/css/swiper-bundle.min.css');
$themeResourceManager->addCSS('assets/css/animate.css');
$themeResourceManager->addCSS('assets/css/tailwind.css');
$themeResourceManager->addJavaScript('assets/js/wow.min.js');
$themeResourceManager->addScript('new WOW().init();');

$themeResourceManager->scripts();
$themeResourceManager->css();
?>

<!-- DodoCMS : ResourceManager -->
<?php
/** @var $resourceManager ResourceManager */
include(Application::get()->toRoot('/core/ui/views/system/head_required.php'));
$resourceManager->scripts();
$resourceManager->css();
?>
