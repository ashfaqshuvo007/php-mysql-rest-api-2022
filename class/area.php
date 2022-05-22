<?php
    class Area{
        // Connection
        private $conn;
        // Table
        private $db_table = "areas";
        // Columns
        public $id;
        public $name;
        public $created;
        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }
        // GET ALL
        public function getAreas(){
            $sqlQuery = "SELECT id, name, created FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
        // CREATE
        public function createArea(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        name = :name, 
                        created = :created";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->created=htmlspecialchars(strip_tags($this->created));
        
            // bind data
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":created", $this->created);
        
            if($stmt->execute()){
               return $this->conn->lastInsertId();
            }
            return false;
        }
        // READ single
        public function getSingleArea(){
            $sqlQuery = "SELECT
                        id, 
                        name,
                        created
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       id = ?
                    LIMIT 0,1";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->name = $dataRow['name'];
            $this->created = $dataRow['created'];
        }    
        
        //Getsingle by name
        // READ single
        public function getSingleAreaByName($name){
           
            $sqlQuery = "SELECT
                        id, 
                        name,
                        created
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       name = ?
                    LIMIT 0,1";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1, $this->name);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $dataRow;
        } 
      
        // DELETE
        function deleteArea(){
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