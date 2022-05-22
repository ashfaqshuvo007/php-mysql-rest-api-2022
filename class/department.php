<?php
    class Department{
        // Connection
        private $conn;
        // Table
        private $db_table = "departments";
        // Columns
        public $id;
        public $name;
        public $created;
        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }
        // GET ALL
        public function getDepartments(){
            $sqlQuery = "SELECT id, name, created FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
        // CREATE
        public function createDepartment(){
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
        public function getSingleDepartment($id){
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
        public function getSingleDepartmentByName($name){
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
            $stmt->bindParam(1, $name);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            return $dataRow;
        }  

        // DELETE
        function deleteDepartment(){
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