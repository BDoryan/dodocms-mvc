<div class="dodocms-p-4 dodocms-rounded-lg dodocms-border-[1px] dodocms-border-white dodocms-border-opacity-25 dodocms-bg-gray-800">
    <h1>Resource Viewer : démo</h1>
    <?php

    /** @var ResourceModel $resource */
    $resources = array_map(function ($resource) {
        $resource_data = $resource->toArray();
        $resource_data['src'] = $resource->getURL();
        return $resource_data;
    }, ResourceModel::findAll('*'));
    $resources = array_slice($resources,0, 5);

    $json = Tools::parseJsonToHtmlAttribute(json_encode($resources, JSON_HEX_QUOT));
    ?>
    <resource-viewer :editable="true" deletable="true" :selectable="true"
                     :items="<?= $json ?>"></resource-viewer>
</div>