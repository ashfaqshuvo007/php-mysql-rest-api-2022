<?php
    class User{
        // Connection
        private $conn;
        // Table
        private $db_table = "users";
        // Columns
        public $id;
        public $name;
        public $email;
        public $created;
        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }
        // CREATE
        public function createUser(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        name = :name, 
                        email = :email, 
                        created = :created";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->created=htmlspecialchars(strip_tags($this->created));
        
            // bind data
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":created", $this->created);
        
            if($stmt->execute()){
               return $this->conn->lastInsertId();
            }
            return false;
        }

        // READ single
        public function getSingleUser($id){
            $sqlQuery = "SELECT
                        name, 
                        email,
                        created 
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
        public function getSingleUserByEmail($email){
            $sqlQuery = "SELECT
                        id, 
                        name, 
                        email, 
                        created
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       email = ?
                    LIMIT 0,1";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1, $email);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            return $dataRow;
            
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
?>