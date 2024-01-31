<?=
    fetch(Application::get()->toRoot('/core/ui/views/admin/head'), [
        'title' => 'DodoCMS - '.($title ?? 'untitled')
    ]);
?>
<script>
    $(document).on('submit', '#setup', function (e) {
        const form = $(this);
        if(!FormUtils.checkForm(form)) e.preventDefault();
    });
</script>