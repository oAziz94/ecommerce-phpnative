<?php
include_once "database.php";
include_once "operation.php";
class Address extends database implements operation {
    private $id;
    private $street;
    private $building;
    private $floor;
    private $flat;
    private $notes;
    private $user_id;
    private $region_id;
    private $created_at;
    private $updated_at;

    // getters
    public function getId()
    {
        return $this->id;
    }
    public function getStreet()
    {
        return $this->street;
    }
    public function getBuilding()
    {
        return $this->building;
    }
    public function getFloor()
    {
        return $this->floor;
    }
    public function getFlat()
    {
        return $this->flat;
    }
 
    public function getNotes()
    {
        return $this->notes;
    }
    public function getUserId()
    {
        return $this->user_id;
    }
    public function getRegionId()
    {
        return $this->region_id;
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
    public function setStreet($street)
    {
        $this->street = $street;
    }
    public function setBuilding($building)
    {
        $this->building = $building;
    }
    public function setFloor($floor)
    {
        $this->floor = $floor;
    }
    public function setFlat($flat)
    {
        $this->flat = $flat;
    }
    
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }
    public function setRegionId($region_id)
    {
        $this->region_id = $region_id;
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
        $query="UPDATE `addresses` SET 
        `addresses`.`street` = '$this->street' , `addresses`.`floor` = '$this->floor' ,
        `addresses`.`building` = '$this->building' , `addresses`.`flat` = '$this->flat' ,
        `addresses`.`region_id` = $this->region_id , `addresses`.`notes` = '$this->notes'
        WHERE `addresses`.`id` = $this->id";
        // echo $query;die;
        return $this->runDML($query);

    }
    public function deleteData(){
        $query = "DELETE FROM `addresses` WHERE `addresses`.`id` = $this->id";
        return $this->runDML($query);
    }
    public function insertData(){
        $query = "INSERT INTO `addresses` 
        (`addresses`.`street`,`addresses`.`floor`,`addresses`.`building`,
        `addresses`.`flat` ,`addresses`.`notes` ,`addresses`.`region_id`,
        `addresses`.`users_id`)
         VALUES ('$this->street','$this->floor','$this->building',
         '$this->flat','$this->notes',$this->region_id,$this->user_id) ";
        //  echo $query;die;
        return $this->runDML($query);
    }
    public function getAllData(){
        
    }

    public function getUserAddresses()
    {
        $query = "SELECT `addresses`.* FROM `addresses` WHERE `addresses`.`users_id` = $this->user_id";
        return $this->runDQL($query);
    }
    
}

?>