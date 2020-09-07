<?php
    class Mark{
        // attributes for marks table 
        private $id;
        private $name;
        private $technial;
        private $non_technical;

        // databse attributues
        private $db_con;
        private $table_name = 'marks';

        // just get the connection variable to interact to the database
        public function __construct($db_connection) {
            $this->db_con = $db_connection;
        }

        // get the marks from db 
        public function read_marks() {
            // SELECT * FROM marks; 
            $query = 'SELECT * FROM '.$this->table_name;
            // prepare the query
            $statement = $this->db_con->prepare($query);
            // execute the query 
            $statement->execute();

            return $statement;
        }


    }
?>

