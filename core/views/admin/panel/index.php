<?php
    if(empty($section)) {
        echo "404 Not Found !";
        exit;
    }

    view(__DIR__ . '/sections/' .$section.'.php');