<?php

class validation
{
    private $password;
    private $confirmPassword;
    private $email;

    public function getPassword()
    {
        return $this->passowrd;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getConfrimPassword()
    {
        return $this->confirmPassword;
    }
    public function setConfrimPassword($confirmPassword)
    {
        $this->confirmPassword = $confirmPassword;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function passwordValidation()
    {
        $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
        $errors = [];
        if (!$this->password) {
            $errors['password'] = "<div class='alert alert-danger'> Passwrod is required </div>";
        }

        if (!$this->confirmPassword) {
            $errors['confirmPassword'] = "<div class='alert alert-danger'> Confrim Passwrod is required </div>";
        }

        if (!isset($errors['password']) || !isset($errors['confrimPassword'])) {

            if (!preg_match($pattern, $this->password)) {
                $errors['pattern'] = "<div class='alert alert-danger'> Passwrod Must Be Minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character </div>";
            }
            if ($this->password != $this->confirmPassword) {
                $errors['confirm'] = "<div class='alert alert-danger'> Passwrod Confirmation is Wrong </div>";
            }
        }

        return $errors;
    }

    public function emailValidation()
    {
        $pattern = "/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/";
        $errors = [];
        if (!$this->email) {
            $errors['required'] = "<div class='alert alert-danger'>  Email is required </div>";
        } else {
            if (!preg_match($pattern, $this->email)) {
                $errors['pattern'] = "<div class='alert alert-danger'> Wrong Email format </div>";
            }
        }
        return $errors;
    }

    public function emailValidationURL($data)
    {
        // print_r($data);die;

        // if $_GET has data
        if ($data) {
            // if $_GET HAS KEY EMAIL
            if (isset($data['email'])) {
                // if $_GET['email'] has value 
                if ($data['email']) {
                    $emailChecked = new user;
                    $emailChecked->setEmail($data['email']);
                    $verfiyEmail = $emailChecked->checkEamil();
                    // if email exists in db
                    if ($verfiyEmail) {
                        $user = $verfiyEmail->fetch_object();
                        return $user;
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
