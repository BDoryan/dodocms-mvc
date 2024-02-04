<div class="tw-border-gray-500 tw-border-opacity-25 tw-rounded-lg tw-border-[1px] tw-overflow-x-auto tw-shadow-sm tw-text-gray-600 tw-bg-white ">
    <table class="tw-w-full tw-rounded-lg tw-overflow-tw-hidden tw-text-sm">
        <thead class="tw-rounded-md tw-border-gray-500 tw-border-opacity-25 tw-border-b">
        <tr class="tw-rounded-md tw-border-gray-500 tw-border-opacity-25 tw-border-b">
            <?php foreach ($this->columns as $col => $column) { ?>
                <th class="tw-px-4 tw-py-2 tw-text-start tw-border-gray-500 tw-border-opacity-25 <?= $col < (count($this->columns) - 1) ? "tw-border-e" : "" ?>"><?php echo __($column); ?></th>
            <?php } ?>
        </tr>
        </thead>
        <tbody class="tw-mx-2">
        <?php
        if (!empty($this->rows)) {
            for ($line = 0; $line < count($this->rows); $line++) {
                $row = $this->rows[$line];
                ?>
                <tr class="odd:tw-bg-gray-900 odd:tw-bg-opacity-5 tw-text-start tw-py-5">
                    <?php foreach ($this->columns as $col => $column) {
                        $data = $row[$column] ?? '';
                        ?>
                        <td class="tw-whitespace-nowrap tw-py-2 tw-px-4 tw-border-gray-500 tw-border-opacity-25 <?= $line > 0 ? "tw-border-t" : "" ?> <?= $col < (count($this->columns) - 1) ? "tw-border-e" : "" ?>"><?php echo $data; ?></td>
                    <?php } ?>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="<?= count($this->columns) ?>"
                    class="tw-text-xl tw-text-center tw-py-5 tw-border-gray-500 tw-border-opacity-25 tw-bg-gray-900 tw-bg-opacity-5 tw-rounded-b-lg"><?= __("components.table.rows.empty") ?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>