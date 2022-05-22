<?php

class HandleCreate{


    private $user;
    private $location;
    private $shift;
    private $department;
    private $area;
    private $event;
    private $row;
    private $event_id = NULL;
    private $area_id = NULL;
    private $location_id = NULL;
    private $shift_id = NULL;
    private $department_ids = NULL;
    private $ids = [];
    public $created = true;

    public function __construct($user,$location,$shift,$department,$area,$event,$row){
        $this->user = $user;
        $this->location = $location;
        $this->shift = $shift;
        $this->department = $department;
        $this->area = $area;
        $this->event = $event;
        $this->row = $row;
    }

    public function handleChunk(){
        if(!is_null($this->row["user_email"])){
            $currentUser = $this->user->getSingleUserByEmail($this->row["user_email"]);

            if(empty($currentUser)){
                $this->user->name = $this->row["user_name"];
                $this->user->email = $this->row["user_email"];
                $this->user->created = (new DateTime())->format('c');
                $this->user_id = $this->user->createUser();
                if(empty($this->user_id)){
                    $this->created = false;
                }
            }else{
                $this->user_id = $currentUser["id"];
            }
            
        }
        
        //Event
        if(!is_null($this->row["event"])){
            $currentEvent = $this->event->getSingleEventByName($this->row["event"]["name"]);
            
            if(empty($currentEvent)){
                $this->event->name = $this->row["event"]["name"];
                $this->event->start = (new DateTime($this->row["event"]["start"]))->format('c');
                $this->event->end = (new DateTime($this->row["event"]["end"]))->format('c');
                $this->event_id = $this->event->createEvent();
                if(empty($this->event_id)){
                    $this->created = false;
                }
            }else{
                $this->event_id = $currentEvent["id"];
            }
        }
        
        //Area
        if(!is_null($this->row["area"])){
            $currentArea = $this->area->getSingleEventByName($this->row["area"]);
            if(empty($currentArea)){
                $this->area->name = $this->row["area"];
                $this->area->created = (new DateTime())->format('c');
                $this->area_id = $this->area->createArea();
                if(empty($this->area_id)){
                    $this->created = false;
                }
            }else{
                $this->area_id = $currentArea["id"];
            }
            
        }

        // Location
        if(!is_null($this->row["location"])){
            $currentLocation = $this->location->getSingleLocationByName($this->row["location"]);
            if(empty($currentLocation)){

                $this->location->name = $this->row["location"];
                $this->location->created =(new DateTime())->format('c');
                $this->location_id = $this->location->createLocation();
                if(empty($this->location_id)){
                    $this->created = false;
                }
            }else{
                $this->location_id = $currentLocation["id"];
            }
        }

        // Department
        if(!is_null($this->row["departments"])){
            
            foreach($this->row["departments"] as $d){
                $currentDept = $this->department->getSingleDepartmentByName($d);
                if(empty($currentDept)){
                    $this->department->name = $d;
                    $this->department->created = (new DateTime())->format('c');
                    $department_id = $this->department->createDepartment();
                    array_push($this->ids,$department_id);
                }else{
                    array_push($this->ids,$currentDept["id"]);
                }
                
            }
        }
        if(!empty($this->ids)){
            
            $this->department_ids = implode(",",$this->ids);
        }

        //Shift
        $this->shift->type = $this->row["type"];
        $this->shift->start = (new DateTime($this->row["start"]))->format('c');
        $this->shift->end = (new DateTime($this->row["end"]))->format('c');
        $this->shift->location_id = $this->location_id;
        $this->shift->rate = $this->row["rate"];
        $this->shift->charge = $this->row["charge"];
        $this->shift->user_id = $this->user_id;
        $this->shift->event_id = $this->event_id;
        $this->shift->area_id = $this->area_id;
        $this->shift->department_ids = $this->department_ids;
        $this->shift_id = $this->shift->createShift();

        if(empty($this->shift_id)){
            $this->created = false;
        }

        return $this->created;
    }
}
   




?>