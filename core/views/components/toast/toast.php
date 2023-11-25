<!--<div id="toast"-->
<!--     class="toast opacity-0 max-w-lg hidden bg---><?php //= self::STYLES[$this->type] ?><!---700 text-white border-[1px] border-gray-800 border-opacity-50 font-medium py-3 px-5 rounded-lg shadow-lg transform transition duration-500 translate-x-full">-->
<!--    <div class="flex flex-row">-->
<!--        <h3 class="mb-1 text-xl uppercase my-auto lh-1 font-bold">--><?php //= $this->title ?><!--</h3>-->
<!--        <button class="close-toast ms-auto text-sm text-white underline focus:outline-none my-auto text-xl hover:text-gray-400">-->
<!--            <i class="fa-solid fa-close"></i></button>-->
<!--    </div>-->
<!--    <hr class="my-2 border-t-[1px] border-gray-300 border-opacity-25">-->
<!--    <p class="text-md">--><?php //= $this->message ?><!--</p>-->
<!--</div>-->
<script type="module">
    import Toast from "<?= Application::get()->toURL("/core/assets/js/components/toast/Toast.js") ?>";

    $(document).ready(() => {
        new Toast('<?= $this->title ?>', '<?= $this->message ?>', '<?= $this->type ?>', <?= $this->timeout ?>).render();
    })
</script>