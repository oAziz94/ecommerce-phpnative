<?php
include_once "header.php";
include_once "php/User.php";
include_once "php/validation.php";

$validation = new validation;
$user = $validation->emailValidationURL($_GET);


if (isset($_POST['submit'])) {
    // validate on code (5 integers , required)
    $errors = [];
    $emailChecked = new user;
    $emailChecked->setEmail($user->email);
    $emailChecked->setCode($_POST['code']);
    $result = $emailChecked->verifyCode();
    if ($result) {
                    if (isset($_GET['forget']) && $_GET['forget'] == 1) {
                        header('Location:changePassword.php?email='.$_GET['email']);
                    }elseif(isset($_GET['forget']) && $_GET['forget'] == 3){
                        header('Location:my-account.php');
                    }elseif (isset($_GET['forget']) && $_GET['forget'] == 0) {
                        $emailChecked->setStatus(1);
                        $status = $emailChecked->updateStatus();
                        if ($status) {
                            // save data in session
                            // session_start();
                            $_SESSION['user'] = $user;
                            // print_r($_SESSION);die;

                            header('Location:index.php');
                        } else {
                            $errors['someThing'] = "<div class='alert alert-danger'> something went wrong </div>";
                        }
                        // update status

                    } else {
                        header('Location:404.php');
                    }
    } else {
        $errors['code'] = "<div class='alert alert-danger'> Wrong Code </div>";
    }
}

?>

<!-- Breadcrumb Area Start -->
<div class="breadcrumb-area bg-image-3 ptb-150">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h3>Email Verification</h3>
            <ul>
                <li><a href="index.html">Home</a></li>
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
                        <a class="active" data-toggle="tab" href="#lg1">
                            <h4> Verify Your Address </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form method="post">
                                        <input type="text" name="code" placeholder="Code">
                                        <?php
                                        if (isset($errors['code'])) {
                                            echo $errors['code'];
                                        }
                                        ?>
                                        <br><br>
                                        <div class="button-box">
                                            <button name='submit'><span>Verify</span></button>
                                        </div>
                                        <?php
                                        if (isset($errors['someThing'])) {
                                            echo $errors['someThing'];
                                        }
                                        ?>
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