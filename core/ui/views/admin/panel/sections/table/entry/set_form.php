<form class="tw-flex tw-flex-row tw-flex-wrap -tw-mx-2 tw-gap-y-2" method="post" action="<?= $action ?? '' ?>"
      enctype="multipart/form-data">
    <?php

    foreach ($model->getFields() as $key => $field) { ?>
        <div class="<?= $field["size"] ?> tw-px-2">
            <?= $field["field"]->render() ?>
        </div>
    <?php } ?>
    <div class="tw-order-2 tw-px-2 tw-flex tw-flex-row tw-w-full tw-gap-5 tw-mt-3">
        <?=
            $buttons ?? 'No buttons provided.'
        ?>
    </div>
</form>