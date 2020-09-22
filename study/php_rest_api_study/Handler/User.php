<?php

    
    use \Firebase\JWT\JWT;
    
    class User{

        private $id;
        private $name;
        private $username;
        private $password;
        private $created_at;

        private $db_con;
        private $table_name = 'users';

        public function __construct($db_connection,$username,$password){
            $this->db_con = $db_connection;
            $this->username = $username;
            $this->password = $password;
        }

        public function login_user(){
            // SELECT * FROM users WHERE email = this->email AND password = this->password
            $query = 'SELECT * FROM '.$this->table_name.' WHERE email = :email AND password = :password';
            $statement = $this->db_con->prepare($query);
            $statement->execute(['email' => $this->username, 'password' => $this->password]);
            if($statement->rowCount() == 1){
                return true;
            } else {
                return false;
            }
        }

        public function generate_token(){
            $query = 'SELECT * FROM '.$this->table_name.' WHERE email = :email AND password = :password';
            $statement = $this->db_con->prepare($query);
            $statement->execute(['email' => $this->username, 'password' => $this->password]);
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            echo $row['password'];

            $iss = "localhost";
            $iat = time();
            $nbf = $iat +10;
            $exp = $iat + 30;
            $aud = "myusers";
            $userdata = array(
                "id" => $row['id'],
                "name" => $row['name'],
                "email" => $row['email']
            );

            $seceret_key = "lucid123";

            $payload_info = array(
                "iss" => $iss,
                "iat" => $iat,
                "nbf" => $nbf,
                "exp" => $exp,
                "aud" => $aud,
                "data" => $userdata
            );
            // JWT token 
            $JWT = JWT::encode($payload_info, $seceret_key);

            return $JWT;
        }
    }
?>
