<div class="border-gray-500 rounded-lg border-[1px] overflow-x-auto">
    <table class="w-full rounded-lg bg-gray-800 overflow-hidden text-sm">
        <thead class="rounded-md border-gray-500 border-b">
        <tr class="rounded-md border-gray-500 border-b">
            <?php foreach ($this->columns as $col => $column) { ?>
                <th class="px-4 py-2 text-start border-gray-500 <?= $col < (count($this->columns) - 1) ? "border-e" : "" ?>"><?php echo $column; ?></th>
            <?php } ?>
        </tr>
        </thead>
        <tbody class="mx-2">
        <?php if (!empty($this->rows)) { ?>
            <?php foreach ($this->rows as $line => $row) { ?>
                <tr class="odd:bg-gray-800 odd:bg-gray-900 text-start py-5">
                    <?php foreach ($row as $col => $data) { ?>
                        <td class="whitespace-nowrap py-2 px-4 border-gray-500 <?= $line > 0 ? "border-t" : "" ?> <?= $col < (count($this->columns) - 1) ? "border-e" : "" ?>"><?php echo $data; ?></td>
                    <?php } ?>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="<?= count($this->columns) ?>"
                    class="text-xl text-center py-5 bg-gray-800 border-gray-500 rounded-b-lg"><?= __("components.table.rows.empty") ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>