<?php


namespace models;


abstract class Model
{
    public $instance;
    public string $table;
    public string $key = 'id';
    private string $query = '';

    public function __construct()
    {
        $this->instance = DB::getInstance();
    }

    public function execute() :array
    {
        $result = [];
        $data = mysqli_query($this->instance->connect, $this->query);

        if ($data) {
            while ($row = mysqli_fetch_assoc($data)) {
                array_push($result, $row);
            }
        }
        return $result;
    }

    public function select(array $columns = []): Model
    {
        if (empty($columns)) {
            $columns = '*';
        } else {
            $columns = implode(',', $columns);
        }
        $this->query .= "SELECT {$columns} FROM {$this->table}";

        return $this;
    }

    public function where($column, $value, $conditions = '='): Model
    {
        $this->query .= " WHERE {$column} {$conditions} '{$value}'";

        return $this;
    }

    public function orWhere($column, $value, $conditions = '='): Model
    {
        $this->query .= " OR {$column} {$conditions} '{$value}'";

        return $this;
    }

    public function find($id): array
    {
        $this->query .= "SELECT * FROM {$this->table} WHERE  {$this->key} = {$id} LIMIT 1";

        return  $this->execute();
    }
}