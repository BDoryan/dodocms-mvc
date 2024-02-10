<title><?= $title ?? 'untitled' ?></title>
<meta name="description" content="<?= $description ?? '' ?>">
<meta name="keywords" content="<?= $keywords ?? '' ?>">
<meta name="author" content="<?= $author ?? '' ?>">


<link rel="stylesheet" href="<?= Application::get()->getTheme()->toURL('assets/css/swiper-bundle.min.css'); ?>" />
<link rel="stylesheet" href="<?= Application::get()->getTheme()->toURL('assets/css/animate.css'); ?>" />
<link rel="stylesheet" href="<?= Application::get()->getTheme()->toURL('assets/css/tailwind.css'); ?>" />

<?php view(Application::get()->toRoot('/core/ui/views/system/head_required.php')); ?>

<script>
    new WOW().init();
</script>
<!-- ==== WOW JS ==== -->
<script src="<?= Application::get()->getTheme()->toURL('assets/js/wow.min.js'); ?>"></script>
