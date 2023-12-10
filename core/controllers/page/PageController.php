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

    /**
     * @throws Exception
     */
    public function viewPage(PageModel $page)
    {
        $start = microtime(true);
        $isAdmin = isset($_GET['isAdmin']);
        ob_start();

        /** @var PageStructureModel $page_structure */
        foreach ($page->getPageStructures() as $page_structure) {
            $block = $page_structure->getBlock();
            $view = $block->getView();
            $block_content = fetch($view, ['block' => $block]);

            $document = new DOMDocument();
            $document->loadHTML('<?xml encoding="UTF-8">' . $block_content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            // apply custom data to the block
            $custom_data = $page_structure->getCustom();
            if (!empty($custom_data)) {
                foreach ($custom_data as $key => $value) {
                    $xpath = new DOMXPath($document);
                    $nodes = $xpath->query('//*[@editable="' . $key . '"]');

//                    echo "<pre style='white-space: pre-wrap'>";
//                    echo htmlspecialchars($value);
//                    echo "</pre>";

                    foreach ($nodes as $node) {
                        $fragment = DOMDocumentUtils::htmlToNode($node, $value);
                        $node->nodeValue = '';
                        $node->appendChild($fragment);
                    }
                }
            }

            // if the user are not admin, remove all editable attributes for security
            if(!$isAdmin) {
                $xpath = new DOMXPath($document);
                $nodes = $xpath->query('//*[@editable or @block-name or @block-content or @page-structure-id]');
                foreach ($nodes as $node) {
                    $node->removeAttribute('editable');
                    $node->removeAttribute('block-name');
                    $node->removeAttribute('block-content');
                    $node->removeAttribute('page-structure-id');
                }
            }

            $block_content = $document->saveHTML();

            if ($isAdmin) {
                view(
                    Application::get()->toRoot('/core/views/admin/liveeditor/block-editor.php'), [
                        'block' => $block,
                        'page_structure' => $page_structure,
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