<?php

class validation {
    private $password;
    private $confirm_password;
    private $email;
    private $code;

    private function getPassword(){
        return $this->password;
    }

    public function getConfirmPassword(){
        return $this->confirm_password;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getCode(){
        return $this->code;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function setConfirmPassword($password){
        $this->confirm_password = $password;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setCode($code){
        $this->code = $code;
    }

    public function passwordValidation(){
        $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,10}$/";
        $errors = [];
        if(!$this->password){
            $errors['password'] = "<div class='alert alert-danger'>Password is required</div>";
        }

        if(!$this->confirm_password){
            $errors['confirm_password'] = "<div class='alert alert-danger'>Password Confirmation is required</div>";
        }

        if(!isset($errors['password']) || !isset($errors['confirm_password'])){
            if(!preg_match($pattern, $this->password)){
                $errors['pattern'] = "<div class='alert alert-danger'>Minimum eight and maximum 10 characters, at least one uppercase letter, one lowercase letter, one number and one special character</div>";
            }
    
            if($this->password != $this->confirm_password){
                $errors['confirm'] = "<div class='alert alert-danger'>Passwords does not match</div>";
            }
        }

        return $errors;
    }

    public function emailValidation(){
        $pattern = "/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/";
        $errors = [];
        if(!$this->email){
            $errors['required'] = "<div class='alert alert-danger'>Email is Required</div>";
        } else {
            if(!preg_match($pattern, $this->email)){
                $errors['pattern'] = "<div class='alert alert-danger'>Wrong Email Format</div>";
            }
        }

        return $errors;
    }

    public function codeValidation(){
        $pattern = "/\b\d{5}\b/";
        $errors = [];
        if(!$this->code){
            $errors['required'] = "<div class='alert alert-danger'>Email is Required</div>";
        } else {
            if(!preg_match($pattern, $this->code)){
                $errors['pattern'] = "<div class='alert alert-danger'>Wrong Code Format</div>";
            }
        }

        return $errors;
    }

    public function emailValidationURL($data){
        if($data){
            // If Key Email Exists
            if(isset($data['email'])){
                // If Email Exists
                if($data['email']){
                    $emailChecked = new User;
                    $emailChecked->setEmail($data['email']);
                    $emailExists = $emailChecked->checkEmail();
                    if($emailExists){
                        return $emailExists->fetch_object();
                    } else {
                        header('Location:404.php');
                    }
                } else {
                    header('Location:404.php');
                }
            } else {
                header('Location:404.php');
            }
        } else {
            header('Location:404.php');
        }
    }
}

?>