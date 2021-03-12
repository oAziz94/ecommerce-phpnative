<?php
include_once "header.php";
include_once "php/User.php";
include_once "php/validation.php";

$validation = new validation;
$user = $validation->emailValidationURL($_GET);

if(isset($_POST['submit'])){
    $errors = [];
    $validation->setPassword($_POST['password']);
    $validation->setConfrimPassword($_POST['passwordConfirmation']);
    
    $passwordValidation = $validation->passwordValidation();

     // update passowrd
     $userPassword = new user;
     $userPassword->setPassword($_POST['password']);
     $userPassword->setEmail($user->email);


    if(empty($passwordValidation)){
        if($user->password == $userPassword->getPassword()){
            $errors['oldPass'] = "<div class='alert alert-danger'> You have entered Old password </div>";
        }else{
           
             $result = $userPassword->updatePassowrd();
             if($result){
                // header home
                $_SESSION['user'] = $user;
                header('Location:index.php');
             }else{
                $errors['someThing'] = "<div class='alert alert-danger'> Something went Wrong </div>";
             }
        }
    }
}
?>

<!-- Breadcrumb Area Start -->
<div class="breadcrumb-area bg-image-3 ptb-150">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h3>New Password</h3>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li class="active">New Password</li>
            </ul>
        </div>
    </div>
</div>
<!-- Breadcrumb Area End -->
<div class="login-register-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <a class="active" data-toggle="tab" href="#lg1">
                            <h4> Change Your Password </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form method="post">
                                        <input type="password" name="password" placeholder="Enter New Password">
                                        <input type="password" name="passwordConfirmation" placeholder="Confirm Password">
                                        <?php
                                        if(!empty($passwordValidation)){
                                            foreach($passwordValidation AS $key=>$value){
                                                echo $value;
                                            }
                                        }
                                        if(!empty($errors)){
                                            foreach($errors AS $key=>$value){
                                                echo $value;
                                            }
                                        }
                                        ?>
                                        <br><br>
                                        <div class="button-box">
                                            <button name='submit'><span>Chnage Password</span></button>
                                        </div>
                                        
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once "footer.php" ?>