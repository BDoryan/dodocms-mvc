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
        $structures = $page->getPageStructures();

        ob_start();
        /** @var PageStructureModel $page_structure */
        for ($i = 0; $i < count($structures); $i++) {
            $page_structure = $structures[$i];

            $block = $page_structure->getBlock();
            $view = $block->getView();
            $block_content = fetch($view, ['block' => $block]);

            $document = new DOMDocument();
//            echo htmlspecialchars($block_content);
            $document->loadHTML(/*'<?xml encoding="UTF-8">' . */$block_content, LIBXML_NOERROR | LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            // apply custom data to the block
            $custom_data = $page_structure->getCustom();
            if (!empty($custom_data)) {
                foreach ($custom_data as $key => $value) {
                    $xpath = new DOMXPath($document);
                    $nodes = $xpath->query('//*[@editable="' . $key . '"]');

                    foreach ($nodes as $node) {
                        // get if is a img
                        if ($node->nodeName === 'img') {
                            $node->setAttribute('src', $value);
                            continue;
                        }
                        $fragment = DOMDocumentUtils::htmlToNode($node, $value);
                        $node->nodeValue = '';
                        $node->appendChild($fragment);
                    }
                }
            }

            // if the user are not admin, remove all editable attributes for security
            if(!$isAdmin) {
                $attributes = [
                    'editable',
                    'block-name',
                    'block-content',
                    'page-structure-id',
                    'model-name',
                    'entity-id',
                    'model-data',
                    'editable-model-data'
                ];

                $query = "//*[@" . implode(' or @', $attributes) . "]";

                $xpath = new DOMXPath($document);
                $nodes = $xpath->query($query);
                foreach ($nodes as $node) {
                    foreach ($attributes as $attribute) {
                        $node->removeAttribute($attribute);
                    }
                }
            }

//            echo htmlspecialchars($document->saveHTML());
//            exit;
            $block_content = $document->saveHTML();

            if ($isAdmin) {
                view(
                    Application::get()->toRoot('/core/views/admin/live-editor/block-editor.php'), [
                        'block' => $block,
                        'page_structure' => $page_structure,
                        'content' => $block_content,
                        'isLast' => $i === count($structures) - 1
                    ]
                );
                continue;

            }

            echo $block_content;
        }

        $content = ob_get_clean();
        if($isAdmin) {
            $content .= '
            <div page-structure-actions>
                <button page-structure-action="add"></button>
            </div>
        ';
        }

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