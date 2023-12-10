<?php

Autoloader::require('models/PageModel.php');

class PageController extends DOMController
{

    public function __construct()
    {
        parent::__construct('page', Application::get()->getTheme()->getViews(), 'assets/', 'head', '/template');
    }

    public function index()
    {
        // Not Found ?
    }

    public function editBlock($params) {
        $block_id = $params['block'];
        $block = Application::get()->getDatabase()->find('Blocks', '*', ['id' => $block_id]);
        if(empty($block))
            return;

        $block = new BlocksModel($block['name'], $block['path']);
        $block->setId($block_id);

        $json = $block->getCustom(0);
        if(empty($json))
            $json = [];

        $json['content'] = $_POST['content'];
        $block->setCustom(0, $json);
        $block->save();
    }

    public function viewPage(PageModel $page)
    {
        $start = microtime(true);
        $isAdmin = isset($_GET['isAdmin']);
        ob_start();

        /** @var BlocksModel $block */
        foreach ($page->getBlocks() as $block) {
            $view = $block->getView();
            $block_content = fetch($view, ['block' => $block]);

            $document = new DOMDocument();
            $document->loadHTML('<?xml encoding="UTF-8">' . $block_content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            // apply custom data to the block
            $custom_data = $block->getCustom($page->getId());
            if (!empty($custom_data)) {
                foreach ($custom_data as $key => $value) {
                    $xpath = new DOMXPath($document);
                    $nodes = $xpath->query('//*[@editable="' . $key . '"]');
                    foreach ($nodes as $node) {
                        $node->nodeValue = $value;
                    }
                }
            }

            // if the user are not admin, remove all editable attributes for security
            if(!$isAdmin) {
                $xpath = new DOMXPath($document);
                $nodes = $xpath->query('//*[@block-name or @block-content or @block-page-id]');
                foreach ($nodes as $node) {
                    $node->removeAttribute('editable');
                    $node->removeAttribute('block-name');
                    $node->removeAttribute('block-content');
                    $node->removeAttribute('page-block-id');
                }
            }

            $block_content = $document->saveHTML();

            if ($isAdmin) {
                view(
                    Application::get()->toRoot('/core/views/admin/liveeditor/block-editor.php'), [
                        'block' => $block,
                        'content' => $block_content
                    ]
                );
                continue;

            }

            echo $block_content;
        }

        $content = ob_get_clean();

        $this->header = $this->fetch("header");
        $this->footer = $this->fetch("footer");

        $this->title = $page->getSeoTitle();
        $this->description = $page->getSeoDescription();
        $this->keywords = $page->getSeoKeywords();

        $now = microtime(true);
        $time = $now - $start;
        echo "<!-- Page generated in " . $time . " seconds -->\n";
        $this->view('layout', ['content' => $content]);
    }
}