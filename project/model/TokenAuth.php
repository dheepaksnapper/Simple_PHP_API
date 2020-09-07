<?php

require_once '../vendor/jwt/jwt.php';
require_once '../vendor/jwt/ExpiredException.php';
require_once '../vendor/jwt/SignatureInvalidException.php';
include_once '../database/Database.php';

use \Firebase\JWT\JWT;


class TokenAuth extends Database{

    private $db_connection;
    private $table = 'user_table';
    private $key = 'Lucid123';
    private $experi_limit = 120;
    private $iss = 'localhsost';

    public function __construct() {
        $this->db_connection = $this->connect();
    }

    public function generate_token($user) {  

        try {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE username = :username';
            $statement  = $this->db_connection->prepare($query);
            $statement->bindParam(':username', $user->username, PDO::PARAM_STR);
            if($statement->execute()) {
                $row = $statement->fetch();
                $iat = time();
                $payload = array(
                    "iss" => $this->iss,
                    "iat" => $iat,
                    "nbf" => $iat + 10,
                    "exp" => $iat + $this->experi_limit,
                    "userdata" => array(
                        "id" => $row['user_id'],
                        "username" => $row['username'],
                        "email" => $row['email']
                    )
                );
        
                $token = JWT::encode($payload, $this->key);
                return $token;
            }
            return '';
        } catch (Exception $e) {
            return '';
        }

    }

    public function verify_token($token) {

        try {
            $decode = (array) JWT::decode($token, $this->key, array('HS256'));
            $query = 'SELECT * FROM ' . $this->table . ' WHERE user_id=:id AND username=:username';
            $statement = $this->db_connection->prepare($query);
            $statement->bindParam(':id', $decode['userdata']->id, PDO::PARAM_STR);
            $statement->bindParam(':username', $decode['userdata']->username, PDO::PARAM_STR);
        } catch (Exception $e) {
            return false;
        } 
        if($statement->execute()) {
            return $statement->rowCount() == 1;
        } 
        return false;
        
    }
}