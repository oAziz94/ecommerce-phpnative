<?php
// MYSQLI ('i' => improved)

class database {

    public $DBserverName = 'localhost';
    public $DBuserName = 'root';
    public $DBpassword = '';
    public $DBname = 'nti_ecommerce';
    public $con;

    function __construct()
    {
        // ('server name', 'username', 'password', 'dbname')
        $this->con = new mysqli($this->DBserverName, $this->DBuserName, $this->DBpassword, $this->DBname);
        if($this->con->connect_error){
            die("connection failed" . $this->con->connect_error);
        } else {
            // echo "Db is connected";
        }

    }

    // DML (data manipulation language) (insert - delete - update)
    public function runDML($query)
    {
        $result = $this->con->query($query);
        if($result){
            return True;
        } else {
            return False;
        }
    }

    // DQL (data query language) (selects)
    public function runDQL($query)
    {
        $result = $this->con->query($query);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            return [];
        }
    }
}

$x = new database;

?>