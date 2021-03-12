<?php 

include_once 'header.php';
include_once 'php/User.php';
include_once 'php/validation.php';
// If Get Has Data
if($_GET){
    // If Key Email Exists
    if(isset($_GET['email'])){
        // If Email Exists
        if($_GET['email']){
            $emailChecked = new User;
            $emailChecked->setEmail($_GET['email']);
            $emailExists = $emailChecked->checkEmail();
            if($emailExists){
                $user = $emailExists->fetch_object();
                
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

if(isset($_POST['verify'])){
    $errors = [];
    $validation = new validation;
    $validation->setCode($_POST['code']);
    $code_validation = $validation->codeValidation();
    $emailChecked->setCode($_POST['code']);
    $result = $emailChecked->verifyCode();
    if($result){
        $emailChecked->setStatus(1);
        $status = $emailChecked->updateStatus();
        if($status){
            //session_start();
            $_SESSION['user'] = $user;
            //print_r($_SESSION);die;
            header("Location:index.php");
        } else {
            $errors['something'] = "<div class='alert alert-danger'>Something Went Wrong</div>";
        }
    } else {
        $errors['code'] = "<div class='alert alert-danger'>Wrong Code!</div>";
    }
}

?>
<!-- Breadcrumb Area Start -->
<div class="breadcrumb-area bg-image-3 ptb-150">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h3>Email Verification</h3>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li class="active">Email Verification</li>
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
                            <h4> Verify Your Address </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg2" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form method="post">
                                        <input type="text" name="code" placeholder="Code">
                                        <?php 
                                            if(!empty($code_validation)){
                                                foreach($code_validation AS $key=>$value){
                                                    echo $value;
                                                }
                                            }

                                            if(isset($errors['code'])){
                                                echo $errors['code'];
                                            }
                                        ?>
                                        <br>
                                        <div class="button-box">
                                            <button name="verify" type="submit"><span>Verify</span></button>
                                            <?php 
                                            if(isset($errors['something'])){
                                                echo $errors['something'];
                                            }
                                        ?>
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