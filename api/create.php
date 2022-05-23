<?php
    include_once 'PostHeader.php';
    require '../class/shift.php';
    require '../class/department.php';
    require '../class/area.php';
    require '../class/event.php';
    require '../class/location.php';
    require '../class/user.php';
    require '../utils/HandleCreate.php';
    require '../config/database.php';

    //Connection
    $database = new Database();
    $db = $database->getConnection();

    $shift = new Shift($db);
    $user = new User($db);
    $location = new Location($db);
    $event = new Event($db);
    $department = new Department($db);
    $area = new Area($db);

    $data = json_decode(file_get_contents("php://input"),true);
    $chunk = [];
    $chunkSize = 2000;
    $shiftNum  = 0;
    $success = true;
    foreach ($data["shifts"] as $singleShift) {
        $shiftNum  += 1;
        $chunk[] = $singleShift;
        
        if($shiftNum % $chunkSize == 0) { // Chunk is full
            
            foreach($chunk as $row){
                $handleCreate = new HandleCreate($user,$location,$shift,$department,$area,$event,$row);
                $success = $handleCreate->handleChunk();
            }
            //Empty the Chunk
            $chunk = [];
        }

    }

    // The very last chunk was not filled to the max, but we still need to import it
    if(count($chunk)) {
        foreach($chunk as $row){
            $handleCreate = new HandleCreate($user,$location,$shift,$department,$area,$event,$row);
            $success = $handleCreate->handleChunk();
        }
    }

    
    if($success){
        http_response_code(200);
        echo json_encode(
            array("message" => "Records created successfully." )
        );
    } else{
        http_response_code(404);
        echo json_encode(
            array(
                "exception" => "Records could not be created"
            )
        );
    }
?>