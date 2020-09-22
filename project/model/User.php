<?php

include_once '../../autoload.php';


class User extends Database{

    private $table = 'user_table';
    private $db_connection;
    private $login = false; //for handling the token generation and validation

    public $user_id;
    public $username;
    public $email;
    public $password;

    public function __construct() {
        $this->db_connection = $this->connect();

    }

    public function create_user() {
        $query = 'INSERT INTO ' . $this->table . ' (user_id, username, email, password) VALUES (:id, :username, :email, :password)';
        try {
            echo 'indie create()';
            $statement = $this->db_connection->prepare($query);
            $statement->bindParam(':id', $this->user_id, PDO::PARAM_STR);
            $statement->bindParam(':username', $this->username, PDO::PARAM_STR);
            $statement->bindParam(':email', $this->email, PDO::PARAM_STR);
            $hash = password_hash($this->password, PASSWORD_DEFAULT);
            $statement->bindParam(':password', $hash, PDO::PARAM_STR);
            return $statement->execute() == 1;

        } catch(PDOException $e) {
            return false;
        }
    }

    public function login_user() {
        try {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE username=:userinput OR email=:userinput';
            $statement = $this->db_connection->prepare($query);
            $statement->bindParam(':userinput', $this->username, PDO::PARAM_STR);
            if($statement->execute()) {
                $user = $statement->fetch();
                if(password_verify($this->password, $user['password']))
                    return true;
                return false;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }
}
