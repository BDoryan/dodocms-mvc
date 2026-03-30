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

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<!-- DodoCMS(<?= Application::theme()->getName() ?>) : ResourceManager  -->
<?php
/** @var $themeResourceManager ResourceManager */

$theme = Application::theme();
$themeResourceManager = $theme->getResourceManager();
$themeResourceManager->addCSS('assets/css/theme.css');
$themeResourceManager->addJavaScript('assets/js/theme.js');
$themeResourceManager->css();
?>

<!-- DodoCMS : ResourceManager -->
<?php
/** @var $resourceManager ResourceManager */
include(Application::get()->toRoot('/core/ui/views/system/head_required.php'));
$resourceManager->scripts();
$resourceManager->css();
?>
