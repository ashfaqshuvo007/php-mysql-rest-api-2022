<?php
 include_once 'config/database.php';

 $db = new Database();


 try {
    $conn = $db->getConnection();
    print("DB Connected");
 }catch(Exception $e){
    print("Connection Failed" + e);
 }

?>