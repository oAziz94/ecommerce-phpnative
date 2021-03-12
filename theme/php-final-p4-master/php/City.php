<?php
include_once "database.php";
include_once "operation.php";
class City extends database implements operation {
    private $id;
    private $name;
    private $latitude;
    private $longitude;
    private $distance;
    private $status;
    private $created_at;
    private $updated_at;

    // getters
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getDistance()
    {
        return $this->distance;
    }
    public function getLatitude()
    {
        return $this->latitude;
    }
    public function getLongitude()
    {
        return $this->longitude;
    }
 
    public function getStatus()
    {
        return $this->status;
    }
   
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdateAt()
    {
        return $this->updated_at;
    }

    // setters
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }
    
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }
   
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    public function updateData(){
     
    }
    public function deleteData(){

    }
    public function insertData(){
    
    }
    public function getAllData(){
        $query = "SELECT `cities`.* FROM `cities` ORDER BY `cities`.`name` ASC ";
        return $this->runDQL($query);
    }
    
}

?>