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
    public function viewPage(AdminController $adminController, PageModel $page)
    {
        $start = microtime(true);
        $editorMode = $adminController->authenticated() && isset($_GET['editor']) && $_GET['editor'] === 'true';
        $structures = $page->getPageStructures();
        $utf8 = "<?xml encoding='utf-8' ?>";

        ob_start();
        /** @var PageStructureModel $page_structure */
        for ($i = 0; $i < count($structures); $i++) {
            $page_structure = $structures[$i];

            $block = $page_structure->getBlock();
            $view = $block->getView();
            $block_content = fetch($view, ['block' => $block]);

            $document = new DOMDocument();

            // Because DOMDocument broke the encoding
            $document->loadHTML($utf8.$block_content, LIBXML_NOERROR | LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            // apply custom data to the block
            $custom_data = $page_structure->getCustom();
            if (!empty($custom_data)) {
                foreach ($custom_data as $key => $value) {
                    $xpath = new DOMXPath($document);
                    $nodes = $xpath->query('//*[@editable="' . $key . '"]');

                    foreach ($nodes as $node) {
//                        if ($node->nodeName === 'img')
//                        $node->setAttribute('resource-id', 1486);
                        if(empty($value))continue;
                        if ($node->nodeName === 'img') {
                            $resource = new ResourceModel();

                            if(!$resource->id($value)->fetch()) {
                                $node->setAttribute('src', "/not_found_404.png");
                                $node->setAttribute('alt', "Resource not found");
                                $node->setAttribute('resource-id', 'resource_not_found');
                            } else {
                                $node->setAttribute('src', $resource->getSrc());
                                $node->setAttribute('alt', $resource->getAlternativeText());
                                $node->setAttribute('resource-id', $value);
                            }
                        }
                        $fragment = DOMDocumentUtils::htmlToNode($node, $value);
                        $node->nodeValue = '';
                        $node->appendChild($fragment);
                    }
                }
            }

            // if the user are not admin, remove all editable attributes for security
            if(!$editorMode) {
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

            $html = $document->saveHTML();

            $html = str_replace("$utf8", '', $html);
            $block_content = $html;


            if ($editorMode) {
                view(
                    Application::get()->toRoot('/core/views/admin/live-editor/block-editor.php'), [
                        'position' => $i,
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
        if($editorMode) {
            $content .= fetch(Application::get()->toRoot('/core/views/admin/live-editor/block-add.php'), [
                'position' => count($structures)
            ]);
            $content .= fetch(
                Application::get()->toRoot('/core/views/admin/live-editor/front.php'), [
                ]
            );
        }

        $this->header = $this->fetch("header");
        $this->footer = $this->fetch("footer");

        $this->title = $page->getSeoTitle();
        $this->description = $page->getSeoDescription();
        $this->keywords = $page->getSeoKeywords();

        $now = microtime(true);
        $time = $now - $start;
        echo "<!-- Page generated in " . $time . " seconds -->\n";
        $this->view('layout', [
            'content' => $content,
            'page_id' => $page->getId(),
            'live_editor' => $editorMode,
            'toasts' => $adminController->getToasts()]);
    }
}