<?php

include_once '../../autoload.php';

class Order extends Database {
    
    private $table = 'order_table';
    private $db_connection;
    
    public $id;
    public $date;
    public $item;
    public $employee;

    public function __construct() {
        $this->db_connection = $this->connect();

    }

    public function read_orders() {
        $query = 'SELECT * FROM ' . $this->table;
        try {

            $statement = $this->db_connection->prepare($query);
            if($statement->execute()) {
                $orders = array();
                while($order = $statement->fetch(PDO::FETCH_ASSOC))
                    $orders[] = ($order);
                return $orders;
            }

        } catch(Exception $e) {
            return '';
        }
    }

    public function write_order() {
        $query = 'INSERT INTO ' . $this->table . '(order_date, item, employee) VALUES (:date, :item, :employee)';
        try {

            $statement = $this->db_connection->prepare($query);
            $statement->bindParam(':date',$this->date, PDO::PARAM_STR);
            $statement->bindParam(':item',$this->item, PDO::PARAM_STR);
            $statement->bindParam(':employee',$this->employee, PDO::PARAM_STR);
            return $statement->execute() == 1;

        } catch (Exception $e) {
            return false;
        }
    }

    public function read_order() {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE ' . 'id=:id';

        try {
            $statement = $this->db_connection->prepare($query); 
            $statement->bindParam(':id', $this->id, PDO::PARAM_INT);
            if($statement->execute()) {
                $orders = array();
                while($order = $statement->fetch(PDO::FETCH_ASSOC))
                    $orders[] = $order;
                return $orders;
            }
        } catch(PDOException $e){
            return '';
        }
        
    }

    public function update_order() {
        $query = 'UPDATE ' . $this->table . ' SET order_date=:date, item=:item, employee=:employee WHERE order_table.id=:id';
        try {
            $statement = $this->db_connection->prepare($query);
            $statement->bindParam(':date', $this->date, PDO::PARAM_STR);
            $statement->bindParam(':item',$this->item, PDO::PARAM_STR);
            $statement->bindParam(':employee',$this->employee, PDO::PARAM_STR);
            $statement->bindParam(':id',$this->id, PDO::PARAM_INT);
            return $statement->execute() == 1;
        } catch(Exception $e) {
            echo $e;
            return false;
        }
        // UPDATE `order_table` SET `order_date` = '2020-09-19', `item` = 'tea1', `employee` = 'Naveen1' WHERE `order_table`.`id` = 1
    }

}

?>