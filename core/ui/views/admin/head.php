<title><?= $title ?? '' ?></title>
<link rel="icon" href="<?= Application::get()->toURL("/core/assets/favicon.png") ?>" sizes="32x32" type="image/png">

<?php view(Application::get()->toRoot('/core/ui/views/system/head_required.php')); ?>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

<script>
    $(document).on('submit', 'form[novalidate]', function (e) {
        const form = $(this);
        if(!FormUtils.checkForm(form)) e.preventDefault();
    });
</script>

<!-- Only in the back-office -->
<script src="<?= Application::get()->toURL('/core/assets/js/scripts/table.js') ?>"></script>