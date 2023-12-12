<title><?= $title ?? 'untitled' ?></title>
<meta name="description" content="<?= $description ?? '' ?>">
<meta name="keywords" content="<?= $keywords ?? '' ?>">
<meta name="author" content="<?= $author ?? '' ?>">

<link rel="stylesheet" href="<?= Application::get()->getTheme()->toURL("/assets/css/style.css") ?>">
<link rel="stylesheet" href="<?= Application::get()->toURL("/core/assets/css/tailwind.css") ?>">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

<link rel="stylesheet" href="<?= Application::get()->toURL("/core/assets/css/dodocms.css") ?>">

<meta name="theme-color" content="#712cf9">
<!--<script src="https://cdn.tailwindcss.com"></script>-->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

<script defer src="<?= Application::get()->toURL("/core/assets/js/scripts/ckeditor.init.js") ?>"></script>
<script src="<?= Application::get()->toURL("/core/assets/js/classes/FormUtils.js") ?>"></script>
<script src="<?= Application::get()->toURL("/core/assets/js/classes/Internationalization.js") ?>"></script>
<script src="<?= Application::get()->toURL("/core/assets/js/classes/Application.js") ?>"></script>
<script>
    DODOCMS_APPLICATION = new Application('<?= Application::get()->getUrl() ?>', '<?= Application::get()->getInternationalization()->getLanguage() ?>', '<?= Application::get()->toURL("/admin/api/") ?>');
</script>
<script type="module" src="<?= Application::get()->toURL("/core/assets/js/modules/select.js") ?>"></script>
<script type="module" src="<?= Application::get()->toURL("/core/assets/js/modules/upload.js") ?>"></script>
<script type="module" src="<?= Application::get()->toURL("/core/assets/js/init.js") ?>"></script>

<script defer src="<?= Application::get()->toURL("/core/assets/js/scripts/live-editor.init.js") ?>"></script>
