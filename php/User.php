<?php
include_once "database.php";
include_once "operation.php";

class User extends database implements operation{

    private $id;
    private $f_name;
    private $l_name;
    private $phone;
    private $email;
    private $code;
    private $status;
    private $gender;
    private $password;
    private $photo;
    private $createdAt;
    private $updatedAt;

    // Getters
    public function getId(){
        return $this->id;
    }

    public function getfName(){
        return $this->f_name;
    }

    public function getlName(){
        return $this->l_name;
    }

    public function getPhone(){
        return $this->phone;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getCode(){
        return $this->code;
    }

    public function getStatus(){
        return $this->status;
    }

    public function getGender(){
        return $this->gender;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getPhoto(){
        return $this->photo;
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

    public function setfName($name){
        $this->f_name = $name;
    }

    public function setlName($name){
        $this->l_name = $name;
    }


    public function setPhone($phone){
        $this->phone = $phone;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setCode($code){
        $this->code = $code;
    }

    public function setStatus($status){
        $this->status = $status;
    }

    public function setGender($gender){
        $this->gender = $gender;
    }

    public function setPassword($password){
        $this->password = sha1($password);
    }

    public function setPhoto($photo){
        $this->photo = $photo;
    }

    public function setCreatedAt($createdAt){
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt($updatedAt){

        $this->updatedAt = $updatedAt;
    }

    public function updateData(){

    }
    public function deleteData(){

    }
    public function insertData(){
        $query = "INSERT INTO `users`
        (`users`.`f_name`, `users`.`last_name`,`users`.`phone`,`users`.`email`,`users`.`gender`,`users`.`password`, `users`.`code`)
        VALUES ('$this->f_name', '$this->l_name', '$this->phone', '$this->email', '$this->gender', '$this->password', '$this->code')";
        return $this->runDML($query);

    }
    public function getAllData(){

    }

    public function checkEmail()
    {
        $query = "SELECT `users` .* FROM `users` WHERE `users`.`email` = '$this->email'";
        return $this->runDQL($query);
    }

    public function checkPhone()
    {
        $query = "SELECT `users` .* FROM `users` WHERE `users`.`phone` = '$this->phone'";
        return $this->runDQL($query);
    }

    public function verifyCode()
    {
        $query = "SELECT `users`.* FROM `users` WHERE `users`.`code` = $this->code AND `users`.`email` = '$this->email' ";
        return $this->runDQL($query);
    }
    
    public function updateStatus(){
        $query = "UPDATE `users` SET `users`.`status` = $this->status WHERE `users`.`email` = '$this->email' ";
        return $this->runDML($query);
    }

    public function login(){
        $query = "SELECT `users`.* FROM `users` WHERE `users`.`email` = '$this->email' AND `users`.`password` = '$this->password' ";
        return $this->runDQL($query);
    }

}

?>