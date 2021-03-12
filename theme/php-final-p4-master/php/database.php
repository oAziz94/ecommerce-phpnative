<?php
// MYSQLI ('i' => improved)

class database {
    public $DBserverName = 'localhost';
    public $DBuserName = 'root';
    public $DBpassword = '';
    public $DBName = 'nti_ecommerce';
    public $con;
    function __construct() {
        // ('serverName','username','password','databaseName')
        $this->con = new mysqli($this->DBserverName,$this->DBuserName,$this->DBpassword,$this->DBName);
        if($this->con ->connect_error){
            die("connection failed ".$this->con->connect_error);
        }else{
            // echo "DB IS connected";
        }
    }

    // DML (data manipulation language) (insert - delete - update )
    public function runDML($query)
    {
        //
        $result = $this->con->query($query);
        if($result){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    // DQL (data query language) (Selects)
    public function runDQL($query)
    {
       $result = $this->con->query($query);
       if($result->num_rows > 0){
            return $result;
       }else{
           return [];
       }
    }
}


?>