<?php

Autoloader::require('models/PageModel.php');

class PageBuilderController extends DOMController
{

    public function __construct()
    {
        parent::__construct('page', Application::get()->getTheme()->getViews(), 'assets/', 'partials/head', '/template');
        $this->resourceManager = new ResourceManager(Application::get()->toUrl('/'));
    }

    public function index()
    {
    }

    public function notFound(AdminController $adminController)
    {
        $content = fetch(Application::theme()->toRoot('/blocks/not-found.php'));

        $this->header = $this->fetch("partials/header");
        $this->footer = $this->fetch("partials/footer");
        $this->scripts = $this->fetch("partials/scripts", [
            'resourceManager' => $this->getResourceManager()
        ]);

        $this->title = __('dodocms.page.not_found');

        $this->view('partials/layout', [
                'content' => $content,
                'page_id' => 'null',
                'live_editor' => 'false',
                'toasts' => $adminController->getToasts()]
        );
    }

    /**
     * @throws Exception
     */
    public function viewPage(AdminController $adminController, PageModel $page)
    {
        /* Start */
        $start = microtime(true);
        $editorMode = $adminController->authenticated() && isset($_GET['editor']) && $_GET['editor'] === 'true';

        /* Start the building of the page */
        $structures = $page->getPageStructures();
        $utf8 = "<?xml encoding='utf-8' ?>";

        /** @var PageController $pageController */
        $pageController = ControllerManager::getPageController($page->getId());

        ob_start();
        for ($i = 0; $i < count($structures); $i++) {
            $page_structure = $structures[$i];

            /** @var BlockModel $block */
            $block = $page_structure->getBlock();
            $view = $block->getView();

            $data = ['block' => $block];

            /** @var PageStructureModel $page_structure */
            if($pageController != null) {
                Application::get()->getLogger()->debug("Page controller found for page " . $page->getId());
                $data_ = $pageController->data();
                Application::get()->getLogger()->debug("data=".print_r($data_, true));
                $data = array_replace($data, $pageController->data());
            }

            /** @var BlockController $blockController */
            $blockController = ControllerManager::getBlockController($block->getId());

            if($blockController != null) {
                Application::get()->getLogger()->debug("Block controller found for block " . $block->getId());
                $data_ = $blockController->data();
                Application::get()->getLogger()->debug("data=".print_r($data_, true));
                $data = array_replace($data, $blockController->data());
            }

            /** @var StructureController $structureController */
            $structureController = ControllerManager::getStructureController($page_structure->getId());
            if($structureController != null) {
                Application::get()->getLogger()->debug("Structure controller found for structure " . $page_structure->getId());
                $data_ = $structureController->data();
                Application::get()->getLogger()->debug("data=".print_r($data_, true));
                $data = array_replace($data, $structureController->data());
            }

            Application::get()->getLogger()->debug("Data for block " . $block->getId() . " : " . print_r($data, true));
            echo "<!-- Block " . $block->getId() . " -->\n";

            try {
                if($view == null) {
                    Application::get()->getLogger()->error("View not found for block " . $block->getId());
                    $block_content = '<div style="padding: 25px;">Failed to load block ' . $block->getId() . ' : View not found</div>';
                } else {
                    $block_content = fetch($view, $data);
                }

                $document = new DOMDocument();

                // Because DOMDocument broke the encoding
                $document->loadHTML($utf8.$block_content, LIBXML_NOERROR | LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

                // Apply custom data to the block
                $custom_data = $page_structure->getCustom();
                if (!empty($custom_data)) {
                    foreach ($custom_data as $key => $value) {
                        $xpath = new DOMXPath($document);
                        $nodes = $xpath->query('//*[@editable="' . $key . '"]');

                        foreach ($nodes as $node) {
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
                        'editable-model'
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

                // PageOptimizer
                $optimizer = new DOMDocumentOptimizer($document);
                $document = $optimizer->optimize();

                $html = $document->saveHTML();

                $html = str_replace("$utf8", '', $html);
                $block_content = $html;

                if ($editorMode) {
                    view(
                        Application::get()->toRoot('/core/ui/views/admin/live-editor/block-editor.php'), [
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
            } catch (Exception $e) {
                echo "Failed to load block " . $block->getId() . " : " . $e->getMessage() . "<br>";
                Application::get()->getLogger()->error($e->getMessage());
            }
        }

        $content = ob_get_clean();
        if($editorMode) {
            $content .= fetch(Application::get()->toRoot('/core/ui/views/admin/live-editor/block-add.php'), [
                'position' => count($structures)
            ]);
            $content .= fetch(
                Application::get()->toRoot('/core/ui/views/admin/live-editor/front.php'), [
                ]
            );
        }

        $this->header = $this->fetch("partials/header");
        $this->footer = $this->fetch("partials/footer");
        $this->scripts = $this->fetch("partials/scripts", [
            'resourceManager' => $this->getResourceManager()
        ]);

        $this->title = $page->getSeoTitle();
        $this->description = $page->getSeoDescription();
        $this->keywords = $page->getSeoKeywords();
        $this->favicon = $page->getFaviconResource();

        $now = microtime(true);
        $time = $now - $start;
        echo "<!-- Page generated in " . $time . " seconds -->\n";
        $this->view('partials/layout', [
                'content' => $content,
                'page_id' => $page->getId(),
                'live_editor' => $editorMode,
                'toasts' => $adminController->getToasts()]
        );
    }
}