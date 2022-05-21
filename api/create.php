<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    include_once '../config/database.php';
    require '../class/shift.php';
    require '../class/department.php';
    require '../class/area.php';
    require '../class/event.php';
    require '../class/location.php';
    require '../class/user.php';

    //Connection
    $database = new Database();
    $db = $database->getConnection();

    $item = new Shift($db);
    var_dump($_FILES);
    die();
    $data = json_decode(file_get_contents("php://input"));
    $item->name = $data->name;
    $item->email = $data->email;
    $item->created = (new DateTime())->format('c');
    
    if($item->createShift()){
        http_response_code(200);
        echo json_encode(
            array("exception" => "User created successfully." )
        );
    } else{
        http_response_code(404);
        echo json_encode(
            array(
                "exception" => "User could not be created"
            )
        );
    }
?>