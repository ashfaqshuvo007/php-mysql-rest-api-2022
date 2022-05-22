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
     public $user_id;
     public $event_id;
     public $location_id;
     public $rate;
     public $charge;
     public $area_id;
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

    //store 
    public function createShift(){
        $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        type = :type, 
                        start = :start, 
                        end = :end, 
                        user_id = :user_id, 
                        event_id = :event_id, 
                        location_id = :location_id, 
                        rate = :rate,
                        charge = :charge, 
                        area_id = :area_id, 
                        department_ids = :department_ids";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->type=htmlspecialchars(strip_tags($this->type));

            // bind data
            $stmt->bindParam(":type", $this->type);
            $stmt->bindParam(":start", $this->start);
            $stmt->bindParam(":end", $this->end);
            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->bindParam(":event_id", $this->event_id);
            $stmt->bindParam(":location_id", $this->location_id);
            $stmt->bindParam(":rate", $this->rate);
            $stmt->bindParam(":charge", $this->charge);
            $stmt->bindParam(":area_id", $this->area_id);
            $stmt->bindParam(":department_ids", $this->department_ids);
            $stmt->execute();
            return $this->conn->lastInsertId();
        
    }







}