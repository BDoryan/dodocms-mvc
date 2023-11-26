<script type="module">
    import Toast from "<?= Application::get()->toURL("/core/assets/js/components/toast/Toast.js") ?>";

    $(document).ready(() => {
        new Toast('<?= $this->getTitle() ?>', '<?= $this->getMessage() ?>', '<?= $this->type ?>', <?= $this->timeout ?>).render();
    })
</script>