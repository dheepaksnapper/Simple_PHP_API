<?php
    // a class for database connection 
    class Database{
        // database parameters from config.json file 
        private $host = 'localhost';
        private $db_name = 'test';
        private $username = 'root';
        private $password = '';
        // connection variable 
        private $db_con;

        // connection function 
        public function connect(){
            $this->db_con = null;

            // establish db connection using PDO 
            // 1. create data node structure 
            // 2. create POD instance 
            try{
                // msql:host=localhost;dbname=test 
                $dns = 'mysql:host='.$this->host.';dbname='.$this->db_name;
                $this->db_con = new PDO($dns,$this->username,$this->password);
                $this->db_con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                // echo 'Connected Succesfully';
            }catch(PDOExceptio $e){
                echo 'Connection Error : '. $e->getMessage();
            }

            return $this->db_con;
        }
    }
    
?>
