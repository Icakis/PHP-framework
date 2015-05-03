<?php

namespace Models;

include_once 'baseModel.php';

class TodosModel extends BaseModel
{
    protected $title;

    public function __construct($args = array())
    {
        $args['table'] = 'todos';
        parent::__construct($args);
        $this->title = 'Users';
    }

    public function getTodoItems($user_id)
    {
        // return parent::find(array('where' => 'user_id = ' . $user_id));

        $statement = $this->dbConnection->prepare("SELECT * FROM todos WHERE user_id = ?");
        $statement->bind_param("i", $user_id);
        $statement->execute();
        $result_set = $statement->get_result();

        $results = array();

        if (!empty($result_set) && $result_set->num_rows > 0) {
            while ($row = $result_set->fetch_assoc()) {
                $results[] = $row;
            }
        }

        return $results;
    }

    public function addTodoItems($user_id, $todo_text)
    {
        // return parent::add(array('user_id' => $user_id, 'todo_item' => $todo_text));

        if ($todo_text == '') {
            throw new \Exception('Cannot create todo with empty text.');
        }

        if ($user_id == '') {
            throw new \Exception('Invalid user id.');
        }

        $statement = $this->dbConnection->prepare("INSERT INTO todos (todo_item, user_id) VALUES(?, ?)");
        $statement->bind_param("si", $todo_text, $user_id);
        $statement->execute();
        return $statement->affected_rows > 0;
    }

    public function deleteTodoItem($user_id, $todo_id)
    {
        if ($todo_id == '' && is_int($todo_id)) {
            throw new \Exception('Invalid item id.');
        }

        if ($user_id == '') {
            throw new \Exception('Invalid user id.');
        }

        $todo_id =(int)$todo_id;
        $statement = $this->dbConnection->prepare("DELETE FROM todos WHERE id = ? and user_id = ?");
        $statement->bind_param("ii", $todo_id, $user_id);
        $statement->execute();
        return $statement->affected_rows > 0;
    }
} 