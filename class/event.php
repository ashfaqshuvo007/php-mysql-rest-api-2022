<?php
    class Event{
        // Connection
        private $conn;
        // Table
        private $db_table = "events";
        // Columns
        public $id;
        public $name;
        public $start;
        public $end;
        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }
        // GET ALL
        public function getEvents(){
            $sqlQuery = "SELECT id, name, start, end FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
        // CREATE
        public function createEvent(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        name = :name, 
                        start = :start, 
                        end = :end";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->start=htmlspecialchars(strip_tags($this->start));
            $this->end=htmlspecialchars(strip_tags($this->end));
        
            // bind data
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":start", $this->start);
            $stmt->bindParam(":end", $this->end);
        
            if($stmt->execute()){
               return $this->conn->lastInsertId();
            }
            return false;
        }
        // READ single
        public function getSingleEvent($id){
            $sqlQuery = "SELECT
                        id, 
                        name, 
                        start, 
                        end
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       id = ?
                    LIMIT 0,1";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            return $dataRow;
        } 
        
         // READ single
         public function getSingleEventByName($name){
            $sqlQuery = "SELECT
                        id, 
                        name, 
                        start, 
                        end
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       name = ?
                    LIMIT 0,1";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1, $name);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $dataRow;
        }  
        
        // DELETE
        function deleteEvent(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }
    }
?>