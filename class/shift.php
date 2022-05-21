<?php

class Shift{

     // Connection
     private $conn;
     // Table
     private $db_table = "shifts";
     // Columns
     public $id;
     public $type;
     public $start;
     public $end;
     public $user_name;
     public $user_email;
     public $event_id;
     public $location;
     public $rate;
     public $charge;
     public $area;
     public $department_ids;
     // Db connection
    public function __construct($db){
         $this->conn = $db;
    }

    // GET ALL
    public function getShifts(){
        $sqlQuery = "SELECT * FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }







}