<?php
    
    
    include_once '../api/PostHeader.php';
    include_once '../config/database.php';
    require '../class/shift.php';
    require '../class/department.php';
    require '../class/area.php';
    require '../class/event.php';
    require '../class/location.php';
    require '../class/user.php';
    require_once '../utils/HandleFetch.php';


   
    $database = new Database();
    $db = $database->getConnection();

    $data = json_decode(file_get_contents("php://input"), true);
    $from = date('Y-m-d H:i:s',strtotime($data["from"]));
    $to = date('Y-m-d H:i:s',strtotime($data["to"]));
    $locationName = htmlspecialchars(strip_tags(stripcslashes($data["location"])));
    $limit = ( isset( $data['limit'] ) ) ? htmlspecialchars(strip_tags($data["limit"])) : 100;
    $page = ( isset( $data['page'] ) ) ? htmlspecialchars(strip_tags($data["page"])) : 1;

    //Fetch data
    $shift = new Shift($db);
    $department =  new Department($db);
    $area =  new Area($db);
    $event =  new Event($db);
    $location =  new Location($db);
    $user =  new User($db);

    $locationDetails = $location->getSingleLocationByName($locationName);

    /**
     * This block can be used for large dataset
     */
    // if ($limit == 'all' ) {
    //     $data = $shift->getShiftsByLocationBetweenTimes($locationDetails["id"],$from,$to);
    // } else {
    //     $page = (( $page - 1) * $limit );
    //     $data = $shift->getShiftsByLocationBetweenTimes($locationDetails["id"],$from,$to,$limit,$page);
    // }

    $data = $shift->getShiftsByLocationBetweenTimes($locationDetails["id"],$from,$to);
    
    $itemCount = count($data);
    if($itemCount > 0){
        
        $shiftArr = array();
        $shiftArr["total"] = $itemCount;
        $shiftArr["shifts"] = array();
        

        $eventDetails = NULL;
        $locationName = NULL;
        $areaName = NULL;


        foreach ($data as $row){
            
            $userDetails = $user->getSingleUser($row["user_id"]);
            if(!is_null($row["event_id"])){
                $eventDetails = $event->getSingleEvent($row["event_id"]);
            }
            
            if(!is_null($row["location_id"])){
                $locationName= $location->getSingleLocation($row["location_id"]);
            }
            
            if(!is_null($row["department_ids"])){
                $dept_ids = explode(",",$row["department_ids"]);
                $dept_names = [];
                foreach($dept_ids as $dept_id){
                    $name = $department->getSingleDepartment($dept_id); 
                    array_push($dept_names,$name["name"]);
                }
            }

            if(!is_null($row["area_id"])){
                $areaName = $area->getSingleArea($row["area_id"]);
            }
            
            
            $shift = array(
                "type" => $row["type"],
                "start" => (new DateTime($row["start"]))->format('c'),
                "end" => (new DateTime($row["end"]))->format('c'),
                "user_name" => $userDetails["name"],
                "user_email" => $userDetails["email"],
                "event" => $eventDetails,
                "location" => $locationName["name"],
                "rate" => $row["rate"],
                "charge" => $row["charge"],
                "area" => $areaName,
                "departments" => $dept_names,

            );
            array_push($shiftArr["shifts"], $shift);
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