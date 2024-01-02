<?php

class ApiPageController extends ApiController
{

    /**
     * You can edit the block data of the page structure
     *
     * @param $params
     * @return void
     */
    public function editContentOfBlock($params)
    {
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

    /**
     * You add a block to structure
     *
     * @return void
     */
    public function addBlockToPage()
    {
        try {
            $block_id = $_POST['block_id'];
            $position = $_POST['block_position'] ?? 0;
            $page_id = $_POST['page_id'];

            $new_structure = new PageStructureModel();
            $new_structure->setBlockId($block_id);
            $new_structure->setPageOrder($position);
            $new_structure->setPageId($page_id);

            $structures = PageStructureModel::findAll('*', ['page_id' => $page_id]);
            foreach ($structures as $structure) {
                if ($structure->getPageOrder() >= $position) {
                    $structure->setPageOrder($structure->getPageOrder() + 1);
                    $structure->update();
                }
            }

            if ($new_structure->create()) {
                $this->success("block_add_success", ['structure' => $new_structure->toArray()]);
                return;
            }
        } catch (Exception $e) {
            $this->error("block_add_failed", ['exception' => $e->getMessage()]);
            Application::get()->getLogger()->printException($e);
            return;
        }
        $this->error("block_add_failed", ['exception' => ""]);
    }

    /**
     * You can delete the block from structure
     *
     * @param $params
     * @return void
     */
    public function deleteStructureOfPage($params)
    {
        try {
            $structure_id = $params['id'];
            $structure = new PageStructureModel();
            $structure->id($structure_id);
            $structure->fetch();

            $structures = PageStructureModel::findAll('*', ['page_id' => $structure->getPageId()]);
            foreach ($structures as $structure_) {
                if ($structure_->getPageOrder() > $structure->getPageOrder()) {
                    $structure_->setPageOrder($structure_->getPageOrder() - 1);
                    $structure_->update();
                }
            }

            $structure->delete();
            $this->success("structure_delete_success", ['structure' => $structure->toArray()]);
        } catch (Exception $e) {
            $this->error("structure_delete_failed", ['exception' => $e->getMessage()]);
        }
    }

    public function blocks()
    {
        $blocks = BlockModel::findAll('*');
        $this->success("blocks_found", ['blocks' => $blocks]);
    }
}