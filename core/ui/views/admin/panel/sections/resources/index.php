
<resources :resources="<?= Tools::parseJsonToHtmlAttribute(json_encode($resources ?? [], JSON_HEX_QUOT)) ?>"></resources>
<!--<resource-viewer :deletable="true" :editable="true"  :addable="false" :removable="false" :uploadable="true" :selectable="false"-->
<!--                 :items="--><?php //= Tools::parseJsonToHtmlAttribute(json_encode($resources ?? [], JSON_HEX_QUOT)) ?><!--"></resource-viewer>-->
<!--<modal-upload @resourceUploaded="addResource" @finishUpload="" :multiple="true"></modal-upload>-->