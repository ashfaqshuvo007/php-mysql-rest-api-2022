<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../class/shift.php';
include_once '../class/department.php';
include_once '../class/area.php';
include_once '../class/event.php';
include_once '../class/location.php';
include_once '../class/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$shift = new Shift($db);
$department = new Department($db);
$area = new Area($db);
$event = new Event($db);
$location = new Location($db);

$deleted = false;


if($user->emptyTable()){
    $deleted = true;
}
if($shift->emptyTable()){
    $deleted = true;
}
if($department->emptyTable()){
    $deleted = true;
}
if($area->emptyTable()){
    $deleted = true;
}
if($event->emptyTable()){
    $deleted = true;
}
if($location->emptyTable()){
    $deleted = true;
}

if($deleted){
    echo json_encode("DB cleared!");
} else{
    echo json_encode("Data could not be deleted");
}


?>
