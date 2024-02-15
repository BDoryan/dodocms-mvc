<title><?= $title ?? 'untitled' ?></title>
<meta name="description" content="<?= $description ?? '' ?>">
<meta name="keywords" content="<?= $keywords ?? '' ?>">
<meta name="author" content="<?= $author ?? '' ?>">

<?php view(Application::get()->toRoot('/core/ui/views/system/head_required.php')); ?>

<!-- Load bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

<!-- Load styles of the theme -->
<link rel="stylesheet" href="<?= Application::get()->getTheme()->toURL("/assets/css/style.css") ?>">

<!-- Load dodocms styles -->
<link rel="stylesheet" href="<?= Application::get()->toURL("/core/assets/css/dodocms.css") ?>">