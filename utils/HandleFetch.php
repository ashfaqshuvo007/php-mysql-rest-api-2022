<?php

class HandleFetch{

    private $_conn;
    private $_limit;
    private $_page;
    private $_query;
    private $_total;
    private $shift;
    private $department;
    private $area;
    private $event;
    private $location;
    private $locationName;
    private $user;
    private $from;
    private $to;
    private $limit;
    private $page;

    public function __construct($conn,$query) {
    
        $this->_conn = $conn;
        $this->_query = $query;
        
        $rs= $this->_conn->query( $this->_query );
        $this->_total = $rs->num_rows;
    }

    public function getData() {

        $this->_query = "SELECT QUERY WITH LIMIT";
      
        if ( $this->_limit == 'all' ) {
            $query= $this->_query;
        } else {
            $query= $this->_query . " LIMIT " . ( ( $this->_page - 1 ) * $this->_limit ) . ", $this->_limit";
        }
        $rs= $this->_conn->query( $query );
      
        while ( $row = $rs->fetch_assoc() ) {
            $results[]  = $row;
        }
      
        $result         = new stdClass();
        $result->page   = $this->_page;
        $result->limit  = $this->_limit;
        $result->total  = $this->_total;
        $result->data   = $results;
      
        return $result;
    }



}





?>