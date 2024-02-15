<?php
/** @var $resourceManager ResourceManager */

/* Define all resources cdn */
$resourceManager->addJavaScript('https://code.jquery.com/jquery-3.6.4.min.js');
$resourceManager->addJavaScript('https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js');
$resourceManager->addJavaScript('https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js');
$resourceManager->addJavaScript('https://unpkg.com/vuex@4.1.0/dist/vuex.global.js');
$resourceManager->addCSS('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css', false, 'stylesheet', [
    'integrity' => 'sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==',
    'crossorigin' => 'anonymous',
    'referrerpolicy' => 'no-referrer'
]);

/* Define all resources local */
$resourceManager->addJavaScript(NativeRoutes::ADMIN_RESOURCES_APPLICATION);
$resourceManager->addJavaScript('/core/assets/js/classes/Toast.js');
$resourceManager->addJavaScript('/core/assets/js/classes/FormUtils.js');
$resourceManager->addJavaScript('/core/assets/js/vue/app.js');
if(!Application::get()->needSetup() && Session::authenticated()) {
    $resourceManager->addScript(fetch(Application::get()->toRoot('/core/ui/views/system/vue_components_scripts')));
}
$resourceManager->addCSS('/core/assets/css/live-editor.css');
$resourceManager->addCSS('/core/assets/css/global.css');
$resourceManager->addCSS('/core/assets/css/ckeditor.css');