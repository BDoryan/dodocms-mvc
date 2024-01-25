<div class="dodocms-border-gray-500 dodocms-rounded-lg dodocms-border-[1px] dodocms-overflow-x-auto">
    <table class="dodocms-w-full dodocms-rounded-lg dodocms-bg-gray-800 dodocms-overflow-dodocms-hidden dodocms-text-sm">
        <thead class="dodocms-rounded-md dodocms-border-gray-500 dodocms-border-b">
        <tr class="dodocms-rounded-md dodocms-border-gray-500 dodocms-border-b">
            <?php foreach ($this->columns as $col => $column) { ?>
                <th class="dodocms-px-4 dodocms-py-2 dodocms-text-start dodocms-border-gray-500 <?= $col < (count($this->columns) - 1) ? "dodocms-border-e" : "" ?>"><?php echo __($column); ?></th>
            <?php } ?>
        </tr>
        </thead>
        <tbody class="dodocms-mx-2">
        <?php
        if (!empty($this->rows)) {
            for ($line = 0; $line < count($this->rows); $line++) {
                $row = $this->rows[$line];
                ?>
                <tr class="odd:dodocms-bg-gray-900 dodocms-text-start dodocms-py-5">
                    <?php foreach ($this->columns as $col => $column) {
                        $data = $row[$column] ?? '';
                        ?>
                        <td class="dodocms-whitespace-nowrap dodocms-py-2 dodocms-px-4 dodocms-border-gray-500 <?= $line > 0 ? "dodocms-border-t" : "" ?> <?= $col < (count($this->columns) - 1) ? "dodocms-border-e" : "" ?>"><?php echo $data; ?></td>
                    <?php } ?>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="<?= count($this->columns) ?>"
                    class="dodocms-text-xl dodocms-text-center dodocms-py-5 dodocms-bg-gray-800 dodocms-border-gray-500 dodocms-rounded-b-lg"><?= __("components.table.rows.empty") ?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>