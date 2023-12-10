<?php

class ApiPageController extends ApiController {

    public function editStructure($params) {
        try {
            $structure_id = $params['id'];
            $structure = new PageStructureModel();
            $structure->id($structure_id);
            $structure->fetch();

            $block_json = json_encode($_POST);
            $structure->setBlockJson($block_json);
            $structure->update();
            $this->success("structure_edit_success", ['structure' => $structure->toArray()]);
        } catch (Exception $e) {
            $this->error("structure_edit_failed", ['exception' => $e->getMessage()]);
        }
    }
}