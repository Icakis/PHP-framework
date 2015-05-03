<?php


namespace Models;
include_once 'baseModel.php';

class UsersModel extends BaseModel
{
    public function __construct($args = array())
    {
        $args['table'] = 'users';
        parent::__construct($args);
    }

    public function createUser($username, $password)
    {
        // return parent::add(array('user_id' => $user_id, 'todo_item' => $todo_text));

        if ($username == '') {
            throw new \Exception('Cannot create user with empty username.');
        }

        if ($password == '') {
            throw new \Exception('Cannot create user with empty password.');
        }

        $passwordHashed = password_hash($password, PASSWORD_BCRYPT);
        if ($this->isUsernameExists($username)) {
            throw new \Exception('Username is taken.');
        }

        $statement = $this->dbConnection->prepare("INSERT INTO users (username, passwordHash) VALUES(?, ?)");
        $statement->bind_param("ss", $username, $passwordHashed);
        $statement->execute();
        return $statement->affected_rows > 0;
    }

    public function isValidUser($username, $password)
    {
        $statement = $this->dbConnection->prepare("SELECT id, passwordHash, username FROM users WHERE username = ? LIMIT 1");
        $statement->bind_param('s', $username);

        $statement->execute();
        $result_set = $statement->get_result();
        var_dump($statement->get_result());
        if (($result_set->num_rows) > 0) {
            $row = $result_set->fetch_assoc();
            if (password_verify($password, $row['passwordHash'])) {
                return array('username' => $row['username'], 'user_id' => $row['id']);
            }
        }

        return false;
    }

    public function isUsernameExists($username)
    {
        $statement = $this->dbConnection->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
        $statement->bind_param('s', $username);
        $statement->execute();
        // var_dump($statement->get_result()->num_rows);
        return ($statement->get_result()->num_rows) > 0;
    }
} 