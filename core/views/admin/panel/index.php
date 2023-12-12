<?php
if (empty($section)) {
    echo "Section : 404 Not Found !";
    exit;
}

if (empty($section_data)) $section_data = [];

?>
<?php
if (!empty($alerts)) { ?>
    <div class="alert-container dodocms-mb-5">
        <?php
        array_map(function ($alert) {
            echo $alert->render();
        }, $alerts);
        ?>
    </div>
<?php } ?>
<?php
view(__DIR__ . '/sections/' . $section . '.php', $section_data);
?>