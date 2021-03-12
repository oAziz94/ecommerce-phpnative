<?php

include_once "header.php";
include_once "php/validation.php";
include_once "php/User.php";
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
if(isset($_POST['submit'])){
    $errors = [];
    $validation = new validation;
    $validation->setPassword($_POST['password']);
    $validation->setConfrimPassword($_POST['passwordConfirmation']);
    $passwordValidation = $validation->passwordValidation();

    $validation->setEmail($_POST['email']);
    $emailValidation = $validation->emailValidation();


    if(empty($passwordValidation) && empty($emailValidation)){
        $user = new User;
        $user->setFirst($_POST['first']);
        $user->setLast($_POST['last']);
        $user->setPhone($_POST['phone']);
        $user->setEmail($_POST['email']);
        $user->setPassword($_POST['password']);
        $user->setGender($_POST['gender']);
        $code = rand(99999,10000);
        $user->setCode($code);
        $emailChecked = $user->checkEamil();
        if(!$emailChecked)
            {
                $result = $user->insertData();
                if($result){
                        // send email
                        //Instantiation and passing `true` enables exceptions
                        $mail = new PHPMailer(true);
                        try {
                            //Server settings
                            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                            $mail->isSMTP();                                            //Send using SMTP
                            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                            $mail->Username   = 'ntiecommerce3@gmail.com';                     //SMTP username
                            $mail->Password   = 'NTI@123456';                               //SMTP password
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                            $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                            //Recipients
                            $mail->setFrom('ntiecommerce3@gmail.com', 'NTI Ecommerce');
                            $mail->addAddress($_POST['email'], $_POST['first']);     //Add a recipient
                            

                            //Content
                            $mail->isHTML(true);                                  //Set email format to HTML
                            $mail->Subject = 'Verification Code';
                            $mail->Body    = 'Your Verifcation Code is:<b>'.$code.'</b>';

                            $mail->send();
                            // echo 'Message has been sent';
                            header('Location:checkCode.php?email='.$_POST['email'].'&forget=0');
                            // hello world
                            // nti
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }
                }else{
                    $errors['someThing'] = "<div class='alert alert-danger'> Something Went Wrong </div>";
                }
            }
       
    }

}

?>

        <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area bg-image-3 ptb-150">
            <div class="container">
                <div class="breadcrumb-content text-center">
					<h3>Register</h3>
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li class="active">Register</li>
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
                                    <h4> Register </h4>
                                </a>
                                <?php if(isset($errors['someThing'])){echo $errors['someThing'];}?>
                            </div>
                            <div class="tab-content">
                                <div id="lg1" class="tab-pane active">
                                    <div class="login-form-container">
                                        <div class="login-register-form">
                                        <form method="post">
                                                <input type="text" name="first" placeholder="First Name" value="<?php if(isset($_POST['first'])){echo $_POST['first'];} ?>">
                                                <input type="text" name="last" placeholder="Last Name" value="<?php if(isset($_POST['last'])){echo $_POST['last'];} ?>">
                                                <input name="email" placeholder="Email" type="email"  value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>">
                                                <?php
                                                    if(!empty($emailValidation)){
                                                        foreach($emailValidation AS $key=>$value){
                                                            echo $value;
                                                        }
                                                    }
                                                    if(isset($emailChecked) && $emailChecked){
                                                        echo "<div class='alert alert-danger'> Email Already Exists </div>";
                                                    }
                                                ?>
                                                <input type="tel" name="phone" placeholder="Phone" value="<?php if(isset($_POST['phone'])){echo $_POST['phone'];} ?>">
                                                <input type="password" name="password" placeholder="Password">
                                                <input type="password" name="passwordConfirmation" placeholder="Confirm Password">
                                                <?php 
                                                    if(!empty($passwordValidation )){
                                                        foreach($passwordValidation AS $key=>$value){
                                                            echo $value;
                                                        }
                                                    }
                                                ?>
                                                <select class="form-control" name="gender" id="">
                                                    <option <?php if(isset($_POST['gender']) && $_POST['gender'] == 'm'){echo "selected";} ?> value="m">Male</option>
                                                    <option <?php if(isset($_POST['gender']) && $_POST['gender'] == 'f'){echo "selected";} ?>  value="f">Female</option>
                                                </select>
                                                <br><br>
                                                <div class="button-box">
                                                    <button name ='submit' ><span>Register</span></button>
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
