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

    public function createUser($username, $password, $confirmPassword, $name, $email, $phone = '')
    {
        // return parent::add(array('user_id' => $user_id, 'todo_item' => $todo_text));

        if ($username == '') {
            throw new \Exception('Cannot create user with empty username.');
        }

        if ($password == '') {
            throw new \Exception('Cannot create user with empty password.');
        }

        if (strlen($password) < 2 || strlen($password) > 100) {
            throw new \Exception('Invalid password length.');
        }

        if ($confirmPassword == '') {
            throw new \Exception('Empty field for confirm password.');
        }

        if (strlen($confirmPassword) < 2 || strlen($confirmPassword) > 100) {
            throw new \Exception('Invalid confirm password length.');
        }

        if ($password !== $confirmPassword) {
            throw new \Exception('Passwords values not same.');
        }

        if ($name == '') {
            throw new \Exception('Empty field for name.');
        }

        if ($email == '') {
            throw new \Exception('Empty field for email.');
        }

        $passwordHashed = password_hash($password, PASSWORD_BCRYPT);
        if ($this->isUsernameExists($username)) {
            throw new \Exception('Username is taken.');
        }

        $statement = $this->dbConnection->prepare("INSERT INTO users (username, passwordHash, name, email, phone) VALUES(?, ?, ?, ?, ?)");
        $statement->bind_param("sssss", $username, $passwordHashed, $name, $email, $phone);
        $statement->execute();
        return $statement->affected_rows > 0;
    }

    public function loginUser($username, $password)
    {
        $statement = $this->dbConnection->prepare("SELECT id, passwordHash, username, name FROM users WHERE username = ? LIMIT 1");
        $statement->bind_param('s', $username);

        $statement->execute();
        $result_set = $statement->get_result();

        //var_dump($statement->get_result());
        if (($result_set->num_rows) > 0) {
            $row = $result_set->fetch_assoc();
            if (password_verify($password, $row['passwordHash'])) {
                return array('username' => $row['username'], 'user_id' => $row['id'], 'name' => $row['name']);
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

    public function getUserByUsername($username)
    {
        $statement = $this->dbConnection->prepare("SELECT id, username, name, email, phone FROM users WHERE username = ? LIMIT 1");
        $statement->bind_param('s', $username);
        $statement->execute();

        return $statement->get_result()->fetch_assoc();
    }
} 