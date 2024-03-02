<?php

class DOMDocumentOptimizer
{

    private DOMDocument $document;

    public function __construct(DOMDocument $document)
    {
        $this->document = $document;
    }

    /**
     * This method is used to optimize the body of the HTML document.
     *
     * @return DOMDocument
     */
    public function optimize(): DOMDocument
    {
        $configuration = Application::get()->getConfigurationInstance();
        $image_quality = $configuration->get('image_quality');

        // Remove all html comments
        $xpath = new DOMXPath($this->document);
        $comments = $xpath->query('//comment()');
        foreach ($comments as $comment) {
            $comment->parentNode->removeChild($comment);
        }

        // Add lazy loading to images
        $images = $xpath->query('//img');
        foreach ($images as $image) {
            $src = $image->getAttribute('src');
            if (strpos($src, 'http') === 0) {
                continue;
            }

            try {
                $optimizer = new ImageOptimizer(Application::get()->toRoot($src), isset($_GET['ignore_cache']) ?? false);

                // width for the image intval if empty set null
                $width = $image->getAttribute('width');
                $width = empty($width) ? null : intval($width);

                // height for the image intval if empty set null
                $height = $image->getAttribute('height');
                $height = empty($height) ? null : intval($height);

                // get mode of the resize
                $mode = $image->getAttribute('resize-mode');
                $mode = empty($mode) ? ImageOptimizer::RESIZE_MODE_DEFAULT : $mode;

                // Remove resize-mode attribute
                $image->removeAttribute('resize-mode');

                if($optimizer->optimize($image_quality, $width, $height, $mode)) {
                    $src = str_replace(Application::get()->toRoot(''), '', $optimizer->output());
                    $image->setAttribute('src', $src);
                    Application::get()->getLogger()->info('Image optimized: ' . $src);
                } else {
                    throw new Exception('Image optimization failed');
                }
            } catch (Exception $e) {
                Application::get()->getLogger()->error('Failed to optimize image ' . $src);
                Application::get()->getLogger()->printException($e);
            }

            // if loading is not set, we set it to lazy
            if(!$image->hasAttribute('loading'))
                $image->setAttribute('loading', 'lazy');
        }
        return $this->document;
    }

    /**
     * @return DOMDocument
     */
    public function getDocument(): DOMDocument
    {
        return $this->document;
    }
}