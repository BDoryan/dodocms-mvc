<?php

class MarkdownConverter
{
    public static function toHtml($markdownText)
    {
        $markdownText = preg_replace('/###### (.*?)(\n|$)/', '<h6>$1</h6>', $markdownText);
        $markdownText = preg_replace('/##### (.*?)(\n|$)/', '<h5>$1</h5>', $markdownText);
        $markdownText = preg_replace('/#### (.*?)(\n|$)/', '<h4>$1</h4>', $markdownText);
        $markdownText = preg_replace('/### (.*?)(\n|$)/', '<h3>$1</h3>', $markdownText);
        $markdownText = preg_replace('/## (.*?)(\n|$)/', '<h2>$1</h2>', $markdownText);
        $markdownText = preg_replace('/# (.*?)(\n|$)/', '<h1>$1</h1>', $markdownText);
        $markdownText = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $markdownText);
        $markdownText = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $markdownText);
        $markdownText = preg_replace('/\~\~(.*?)\~\~/', '<del>$1</del>', $markdownText);
//        $markdownText = preg_replace('/\`(.*?)\`/', '<code>$1</code>', $markdownText);
        $markdownText = preg_replace('/\[(.*?)\]\((.*?)\)/', '<a href="$2">$1</a>', $markdownText);
        $markdownText = preg_replace('/\n/', '<br>', $markdownText);


        $markdownText = preg_replace('/```(.*?)```/s', '<pre>$1</pre>', $markdownText);

        $markdownText = '<p>' . nl2br($markdownText) . '</p>';

        return $markdownText;
    }
}