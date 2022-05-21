<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once '../config/database.php';
    require '../class/shift.php';
    require '../class/department.php';
    require '../class/area.php';
    require '../class/event.php';
    require '../class/location.php';
    require '../class/user.php';



    $database = new Database();
    $db = $database->getConnection();
    $items = new Shift($db);
    $stmt = $items->getShifts();
    $itemCount = $stmt->rowCount();

    echo json_encode($itemCount);
    if($itemCount > 0){
        
        $shiftArr = array();
        $shiftArr["body"] = array();
        $shiftArr["itemCount"] = $itemCount;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $shifts = array(
                "id" => $id,
                "type" => $type,
                "start" => $start,
                "end" => $end,
                "user_name" => $user_name,
                "user_email" => $user_email,
                "event_id" => $event_id,
                "location" => $location,
                "rate" => $rate,
                "charge" => $charge,
                "area" => $area,
                "department_ids" => $department_ids                                                                                              ,

            );
            array_push($shiftArr["body"], $e);
        }
        echo json_encode($shiftArr);
    }
    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>