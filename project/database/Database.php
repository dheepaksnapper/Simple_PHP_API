<?php
// a class for configuring and connection to database and it uses PDO
class Database{
    private $host = 'localhost';
    private $dbname = 'snacks_db';
    private $username = 'root';
    private $password = '';
    private $db = 'mysql';

    private $connection;

    protected function connect() {
        $dsn = $this->db . ':host=' . $this->host . ';dbname=' . $this->dbname;
        try{

            $this->connection = new PDO($dsn, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $e) {
            echo "connection error" . $e->getMessage();
        }

        return $this->connection;
    }
}
?>