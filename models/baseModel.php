<?php

namespace Models;

class BaseModel
{
    protected $table;
    protected $where;
    protected $columns;
    protected $limit;
    protected $dbConnection;

    public function __construct($args = array())
    {
        $args = array_merge(array(
            'where' => '',
            'columns' => '*',
            'limit' => 0
        ), $args);

        if (!isset($args['table'])) {
            die('Table not defined. Please define a model table.');
        }

        $this->table = $args['table'];
        $this->where = $args['where'];
        $this->columns = $args['columns'];
        $this->limit = $args['limit'];

        $db = \Lib\Database::get_instance();
        $this->dbConnection = $db::get_db();
    }

    public function get($id)
    {
        $results = $this->find(array('where' => 'id = ' . $id));

        return $results;
    }

    public function add($pairs)
    {
        // Get keys and values separately
        $keys = array_keys($pairs);
        $values = array();

        // Escape values, like prepared statement
        foreach ($pairs as $key => $value) {
            $values[] = "'" . $this->dbConnection->real_escape_string($value) . "'";
        }

        $keys = implode($keys, ',');
        $values = implode($values, ',');

        $query = "insert into {$this->table}($keys) values($values)";

// 		var_dump($query);

        $this->dbConnection->query($query);

        return $this->dbConnection->affected_rows;
    }

    public function delete($id)
    {
        $query = "DELETE FROM {$this->table} WHERE id=" . intval($id);

        $this->dbConnection->query($query);

        return $this->dbConnection->affected_rows;
    }

    public function update($model)
    {
        $query = "UPDATE " . $this->table . " SET ";

        foreach ($model as $key => $value) {
            if ($key === 'id') continue;
            $query .= "$key = '" . $this->dbConnection->real_escape_string($value) . "',";
        }
        $query = rtrim($query, ",");
        $query .= " WHERE id = " . $model['id'];

        $this->dbConnection->query($query);

        return $this->dbConnection->affected_rows;
    }

    public function find($args = array())
    {
        $table = $this->table;

        if(!empty($args['columns']) && is_array($args['columns'])){
            $columns= implode(', ', $args['columns']);
        }else {
            $columns = $this->columns;
        }

        $columns = mysqli_real_escape_string($this->dbConnection, $columns);
        $table = mysqli_real_escape_string($this->dbConnection,$table);
        $query ="SELECT $columns FROM $table";

        if (!empty($args['where'])) {
            $query .= ' where ' . mysqli_real_escape_string($this->dbConnection,$args['where']);
        }

        if (!empty($args['limit'])) {
            $query .= ' limit ' . mysqli_real_escape_string($this->dbConnection,$args['limit']);
        }

        $statement = $this->dbConnection->query($query);

        return $statement->fetch_all(MYSQLI_ASSOC);

//        $args = array_merge(array(
//            'table' => $this->table,
//            'where' => '',
//            'columns' => '*',
//            'limit' => 0
//        ), $args);

    }

    protected function process_results($result_set)
    {
        $results = array();

        if (!empty($result_set) && $result_set->num_rows > 0) {
            while ($row = $result_set->fetch_assoc()) {
                $results[] = $row;
            }
        }

        return $results;
    }
}