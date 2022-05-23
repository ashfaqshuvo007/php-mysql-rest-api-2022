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
    public function getShiftsByLocationBetweenTimes($location_id,$from,$to){
        
        $sqlQuery = "SELECT * FROM shifts 
                    WHERE 
                        location_id= ? 
                    AND start >= ? 
                    AND end <= ?";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $location_id);
        $stmt->bindParam(2, $from);
        $stmt->bindParam(3, $to);

        //Can be used for pagination and deal with huge dataset
        // $stmt->bindParam(4, $page);
        // $stmt->bindParam(5, $limit);
        
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
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


     // Empty data
     function emptyTable(){
        $sqlQuery = "TRUNCATE " . $this->db_table."; ALTER TABLE ". $this->db_table ." AUTO_INCREMENT = 1";
        $stmt = $this->conn->prepare($sqlQuery);
        if($stmt->execute()){
            return true;
        }
        return false;
    }




}