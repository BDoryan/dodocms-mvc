<title><?= $title ?? '' ?></title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
      integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
      crossorigin="anonymous" referrerpolicy="no-referrer"/>
<link rel="icon" href="<?= Application::get()->toURL("/core/assets/favicon.png") ?>" sizes="32x32" type="image/png">

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script defer>
    $(document).ready(function () {
        $('.ckeditor').each(function () {
            CKEDITOR.replace($(this).attr('id'));
        });
    });
</script>

<script src="<?= Application::get()->toURL("/core/assets/js/classes/FormUtils.js") ?>"></script>
<script src="<?= Application::get()->toURL("/core/assets/js/classes/Internationalization.js") ?>"></script>
<script src="<?= Application::get()->toURL("/core/assets/js/classes/Application.js") ?>"></script>
<script>
    DODOCMS_APPLICATION = new Application('<?= Application::get()->getUrl() ?>', '<?= Application::get()->getInternationalization()->getLanguage() ?>', '<?= Application::get()->toURL("/admin/api/") ?>');
</script>
<script src="<?= Application::get()->toURL("/core/assets/js/scripts/select.js") ?>"></script>
<script src="<?= Application::get()->toURL("/core/assets/js/scripts/upload.js") ?>"></script>
<script src="<?= Application::get()->toURL("/core/assets/js/init.js") ?>"></script>
