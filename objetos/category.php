<?php
class Category{
 
    // database connection and table name
    private $conn;
    private $table_name = "categories";
 
    // object properties
    public $id;
    public $nome;
    public $description;
    public $created;
 
    public function __construct($db){
        $this->conn = $db;
    }
 
    // used by select drop-down list
    public function readAll(){
        //select all data
        $query = "SELECT
                    id, nome, description
                FROM
                    " . $this->table_name . "
                ORDER BY
                    nome";
 
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
 
        return $stmt;
    }

        // used by select drop-down list
    public function read(){
     
        //select all data
        $query = "SELECT
                    id, nome, description
                FROM
                    " . $this->table_name . "
                ORDER BY
                    nome";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
     
        return $stmt;
    }
}
?>