<?php
include_once "database.php";
include_once "operation.php";

class SubCategory extends database implements operation{

    private $id;
    private $name;
    private $photo;
    private $status;
    private $category_id;
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

    public function getCategory(){
        return $this->category_id;
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

    public function setCategory($id){
        $this->category_id = $id;
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
        
    }

    public function getSubFromCat(){
        $query = "SELECT `sub_categories`.* From `sub_categories` WHERE `categories_id` = $this->category_id ORDER BY `sub_categories`.`name` ASC";
        return $this->runDQL($query); 
    }

}

?>