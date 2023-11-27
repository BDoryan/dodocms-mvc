<?php

class TableComponent extends Component
{

    /**
     * $columns = []
     * $rows = [
     *      ['', '', ''],
     *      ['', '', '']
     * ]
     */

    private array $rows = [];
    private array $columns = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function columns(array $columns): TableComponent
    {
        $this->columns = $columns;
        return $this;
    }

    public function rows(array $rows): TableComponent
    {
        $this->rows = $rows;
        return $this;
    }

    public function addRow(array $row): TableComponent
    {
        $this->rows[] = $row;
        return $this;
    }

    public function isFirst($i): bool
    {
        return $i == 0;
    }

    public function isLast($i, $target): bool
    {
        if (empty($target)) return false;
        return $i >= count($target) - 1;
    }

    public function render()
    {
        include "$this->template/table/table.php";
    }

    public static function create(): TableComponent
    {
        return new TableComponent();
    }
}