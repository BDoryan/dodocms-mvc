<!doctype html>
<html lang="<?= $language ?? "en" ?>">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <?= $head ?? '' ?>
    </head>
    <body>
        <div id="app">
            <?= $content ?? '' ?>
        </div>
        <?= $scripts ?? '' ?>
    </body>
</html>