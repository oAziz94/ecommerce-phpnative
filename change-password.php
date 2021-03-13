<?php 

include_once 'header.php';
include_once 'php/validation.php';
include_once 'php/User.php';
$validation = new validation;
$user = $validation->emailValidationURL($_GET);

if(isset($_POST['submit'])){
    $errors = [];
    $validation->setPassword($_POST['password']);
    $validation->setConfirmPassword($_POST['password-confirmation']);

    $passValidation = $validation->passwordValidation();

    $newPassword = new User;
    $newPassword->setEmail($user->email);
    $newPassword->setPassword($_POST['password']);

    if(empty($passValidation)){
        if($user->password == $newPassword->getPassword()){
            $errors['old-password'] = "<div class='alert alert-danger'>You Have Entered An Old Password</div>";
        } else {
            $result = $newPassword->updatePassword();
            if($result){
                session_start();
                $_SESSION['user'] = $user;
                header("Location:index.php");
            } else {
                $errors['something'] = "<div class='alert alert-danger>Something Went Wrong</div>";
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
                <li><a href="index.php">Home</a></li>
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
                        <a class="active" data-toggle="tab" href="#lg2">
                            <h4> Change Your Password </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg2" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form method="post">
                                        <input type="email" name="password" value="<?php if(isset($user)) {echo $user->email;} ?>" disabled>
                                        <input type="password" name="password" placeholder="New Password">
                                        <input type="password" name="password-confirmation" placeholder="Confirm Password">
                                        <?php
                                            if(!empty($passValidation)){
                                                foreach($passValidation AS $key=>$value){
                                                    echo $value;
                                                }
                                            }

                                            if(!empty($errors)){
                                                foreach($errors AS $key=>$value){
                                                    echo $value;
                                                }
                                            }
                                        ?>
                                        <br>
                                        <div class="button-box">
                                            <button name="submit" type="submit"><span>Change Password</span></button>
                                            
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
<?php include_once 'footer.php' ?>