<?php
include_once "database.php";
include_once "operation.php";
class User extends database implements operation {
    private $id;
    private $first;
    private $last;
    private $phone;
    private $email;
    private $code;
    private $gender;
    private $photo;
    private $password;
    private $status;
    private $created_at;
    private $updated_at;

    // getters
    public function getId()
    {
        return $this->id;
    }
    public function getFirst()
    {
        return $this->first;
    }
    public function getLast()
    {
        return $this->last;
    }
    public function getPhone()
    {
        return $this->phone;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getCode()
    {
        return $this->code;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getGender()
    {
        return $this->gender;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    public function getPhoto()
    {
        return $this->photo;
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
    public function setFirst($first)
    {
        $this->first = $first;
    }
    public function setLast($last)
    {
        $this->last = $last;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
    public function setPassword($password)
    {
        $this->password = sha1($password);
    }
    public function setGender($gender)
    {
        $this->gender = $gender;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }
    public function setCode($code)
    {
        $this->code = $code;
    }
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    public function updateData(){
        $query = "UPDATE `users` SET `users`.`first` = '$this->first' ,
        `users`.`last` = '$this->last',
        `users`.`phone` = '$this->phone', ";
        if($this->photo){
            $query .= " `users`.`photo` = '$this->photo',";
        }
        $query .=" `users`.`gender` = '$this->gender'
         WHERE `users`.`id` = $this->id ";
        return $this->runDML($query);
    }
    public function deleteData(){

    }
    public function insertData(){
        $query = "INSERT INTO `users` 
        (`users`.`first`,`users`.`last`,`users`.`phone`,`users`.`email`,`users`.`password`,`users`.`gender`,`users`.`code`) 
        VALUES ('$this->first','$this->last','$this->phone','$this->email','$this->password','$this->gender',$this->code)";
        // echo $query;die;
        return $this->runDML($query);
    }
    public function getAllData(){
        
    }
    public function checkEamil()
    {
        $query = "SELECT `users`.* FROM `users` WHERE `users`.`email` = '$this->email'";
        return $this->runDQL($query);
    }
    public function verifyCode()
    {
        $query = "SELECT `users`.* FROM `users` WHERE `users`.`code` = $this->code AND `users`.`email` = '$this->email' ";
        return $this->runDQL($query);
    }
    
    public function updateStatus()
    {
       $query = "UPDATE `users` SET `users`.`status` = $this->status WHERE `users`.`email` = '$this->email' ";
       return $this->runDML($query);

    }
    
    public function login()
    {
        $query = "SELECT `users`.* FROM `users` WHERE `users`.`email` = '$this->email' AND `users`.`password` = '$this->password'";
        return $this->runDQL($query);
    }

    public function updateCode()
    {
        $query = "UPDATE `users` SET `users`.`code` = $this->code WHERE `users`.`email` = '$this->email'";
        return $this->runDML($query);
    }

    public function updatePassowrd()
    {
        $query = "UPDATE `users` SET `users`.`password` = '$this->password' WHERE `users`.`email` = '$this->email' ";
        return $this->runDML($query);
    }

    public function getUser()
    {
        $query = "SELECT `users`.* FROM `users` WHERE `users`.`id` = $this->id ";
        return $this->runDQL($query);
    }

    public function changePassword()
    {
       $query = "UPDATE `users` SET `users`.`password` = '$this->password' WHERE `users`.`id` = $this->id";
       return $this->runDML($query);
    }
    public function updateEmail()
    {
        $query = "UPDATE `users` SET `users`.`email` = '$this->email' , `users`.`code` = $this->code , `users`.`status`=$this->status WHERE `users`.`id` = $this->id ";
        return $this->runDML($query);
    }
    
}

?>