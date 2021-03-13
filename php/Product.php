<?php
include_once "database.php";
include_once "operation.php";

class Product extends database implements operation{

    private $id;
    private $name;
    private $details;
    private $photo;
    private $stock;
    private $code;
    private $status;
    private $price;
    private $sub_categories;
    private $createdAt;
    private $updatedAt;

    // Getters
    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getDetails(){
        return $this->details;
    }

    public function getPhoto(){
        return $this->photo;
    }

    public function getStock(){
        return $this->stock;
    }

    public function getCode(){
        return $this->code;
    }

    public function getStatus(){
        return $this->status;
    }

    public function getPrice(){
        return $this->price;
    }

    public function getSubcategories(){
        return $this->sub_categories;
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

    public function setDetails($details){
        $this->details = $details;
    }

    public function setPhoto($photo){
        $this->photo = $photo;
    }

    public function setStock($stock){
        $this->stock = $stock;
    }

    public function setCode($code){
        $this->code = $code;
    }

    public function setStatus($status){
        $this->status = $status;
    }

    public function setPrice($price){
        $this->price = $price;
    }

    public function setSubcategories($id){
        $this->sub_categories = $id;
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
        $query = "SELECT `products`.* FROM `products`";
        return $this->runDQL($query);
    }

    public function getProducts_Sub(){
        $query = "SELECT `products`.* FROM `products` WHERE `products`.`sub_categories_id` = $this->sub_categories";
        return $this->runDQL($query);
    }

    public function productDetails(){
        $query = "SELECT `product_reviews`.* FROM `product_reviews` WHERE  `product_reviews`.`id` = $this->id";
        return $this->runDQL($query);
    }

    public function getReviewsFromProducts(){
        $query = "SELECT
        `ratings`.*
        , CONCAT(`users`.`f_name`, ' ',  `users`.`last_name`) AS `fullName`
    FROM
        `ratings`
    JOIN `users`
    ON `users`.`id` = `ratings`.`user_id`
    WHERE
        `ratings`.`product_id` = $this->id";
        return $this->runDQL($query);
    }

}

?>