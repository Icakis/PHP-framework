<?php


namespace Models;
include_once 'baseModel.php';

class UsersModel extends BaseModel {
    public function __construct( $args = array() ) {
        $args['table']='users';
        parent::__construct($args);
    }

    public function createUser($username, $password) {
        // return parent::add(array('user_id' => $user_id, 'todo_item' => $todo_text));
        if($this->isValidUser($username, $password)){
            throw new \Exception('Username is taken.');
        }

        if ($username == '') {
            throw new \Exception('Cannot create user with empty username.');
        }

        if ($password == '') {
            throw new \Exception('Cannot create user with empty password.');
        }

        $statement = $this->dbConnection->prepare(
            "INSERT INTO users (username, passwordHash) VALUES(?, ?)");
        $statement->bind_param("ss", $username, $password);
        $statement->execute();
        return $statement->affected_rows > 0;
    }

    public function isValidUser($username, $password) {
        $statement = $this->dbConnection->prepare("SELECT id, passwordHash, username FROM users WHERE username = ? LIMIT 1");
        $statement->bind_param('s', $username);

        $statement->execute();
        var_dump($statement->get_result());
        if($statement->get_result()){
            return true;
        }

        return false;
    }
} 