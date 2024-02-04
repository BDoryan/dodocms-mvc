<?php /** @var $this ResourceViewer */

 ?>
<resource-viewer :multiple="<?= $this->multiple ? "true" : "false" ?>" :name="'<?= $this->name ?>'" :scrollable="true" :selectable="false" :deletable="false" :removable="true" :uploadable="true" :addable="true" :editable="true" :items="<?= Tools::parseJsonToHtmlAttribute($this->resourceToJson()) ?>">
</resource-viewer>