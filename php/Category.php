<?php
include_once "database.php";
include_once "operation.php";

class Category extends database implements operation{

    private $id;
    private $name;
    private $photo;
    private $status;
    private $createdAt;
    private $updatedAt;

    // Getters
    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getPhoto(){
        return $this->photo;
    }

    public function getStatus(){
        return $this->status;
    }


    public function getCreatedAt(){
        return $this->createdAt;
    }

    public function getUpdatedAt(){
        return $this->updatedAt;
    }

    // Setters
    public function setId($id){
        $this->id = $id;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function setPhoto($photo){
        $this->photo = $photo;
    }

    public function setStatus($status){
        $this->status = $status;
    }


    public function setCreatedAt($timestamp){
        $this->createdAt = $timestamp;
    }

    public function setUpdatedAt($timestamp){
        $this->updatedAt = $timestamp;
    }

    public function updateData(){

    }
    public function deleteData(){

    }
    public function insertData(){
    
    }
    public function getAllData(){
        $query = "SELECT `categories`.* FROM `categories` ORDER BY `categories`.`id` ASC LIMIT 4";
        return $this->runDQL($query);
    }

}

?>