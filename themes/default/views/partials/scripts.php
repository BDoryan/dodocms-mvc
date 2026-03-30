<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

<!-- DodoCMS(<?= Application::theme()->getName() ?>) : ResourceManager  -->
<?php
/** @var $themeResourceManager ResourceManager */

$theme = Application::theme();
$themeResourceManager = $theme->getResourceManager();
$themeResourceManager->scripts();
?>
<!-- DodoCMS : ResourceManager -->
<?php
/** @var $resourceManager ResourceManager */
include(Application::get()->toRoot('/core/ui/views/system/scripts_required.php'));
$resourceManager->scripts();
?>
