<?php

class DOMDocumentUtils
{

    public static function htmlToNode($node, $html)
    {
        $html = str_replace('<br type="_moz">', '', $html);
        $fragment = $node->ownerDocument->createDocumentFragment();

        $line = str_replace('<br>', '<br/>', $html);
        $line = preg_replace('/<img(.*?)>/', '<img$1/>', $line);

        $fragment->appendXML($line);
        return $fragment;
    }
}