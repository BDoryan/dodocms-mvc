<?php
if (empty($section)) {
    echo "Section : 404 Not Found !";
    exit;
}

if (empty($section_data)) $section_data = [];

view(__DIR__ . '/sections/' . $section . '.php', $section_data);