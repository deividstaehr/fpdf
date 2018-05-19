<?php

class DB
{
    private $table;
    private $columns;
    private $where;

    public function __construct() {
        $this
            ->table(null)
            ->columns('*')
            ->where('1 = 1');
    }

    public function columns($str_columns)
    {
        $this->columns = $str_columns;

        return $this;
    }

    public function table($table_name)
    {
        $this->table = $table_name;

        return $this;
    }

    public function where($where)
    {
        $this->where = $where;

        return $this;
    }

    public function select($limit = 'ALL')
    {
        if ($this->getTable()) {
            $sql = "SELECT {$this->getColumns()} FROM {$this->getTable()} WHERE {$this->getWhere()} LIMIT {$limit}";

            $dbcon = $this->make();

            $stm = pg_query($dbcon, $sql);
            $result = pg_fetch_all($stm);

            pg_close($dbcon);

            return $result;
        }
        return null;
    }

    private function make()
    {
        $con_string = "host=127.0.0.1 port=5432 dbname=postgres user=postgres password=postgres";
        $bdcon = pg_connect($con_string);

        return $bdcon;
    }

    private function getColumns()
    {
        return $this->columns;
    }

    private function getTable()
    {
        return $this->table;
    }

    private function getWhere()
    {
        return $this->where;
    }
}