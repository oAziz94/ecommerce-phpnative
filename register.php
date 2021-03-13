<?php
include_once 'header.php';
include_once 'php/validation.php';
include_once 'php/User.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

if(isset($_POST['submit'])){
    $validation = new validation;
    $validation->setPassword($_POST['password']);
    $validation->setConfirmPassword($_POST['password_confirmation']);
    $password_validation = $validation->passwordValidation();

    $validation->setEmail($_POST['email']);
    $email_validation = $validation->emailValidation();

    if(empty($password_validation) && empty($email_validation)){
        $user = new User;
        $user->setfName($_POST['first']);
        $user->setlName($_POST['last']);
        $user->setEmail($_POST['email']);
        $user->setPhone($_POST['phone']);
        $user->setPassword($_POST['password']);
        $user->setGender($_POST['gender']);
        $code = rand(99999, 10000);
        $user->setCode($code);
        $emailChecked = $user->checkEmail();
        $phoneChecked = $user->checkPhone();
        if((!$emailChecked) && (!$phoneChecked)) {
            $result = $user->insertData();
            if($result){
                // echo "Data Inserted";

                //Instantiation and passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'omar.abdulaziz71@gmail.com';                     //SMTP username
                    $mail->Password   = 'ok94952012?';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                    $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                    //Recipients
                    $mail->setFrom('omar.abdulaziz71@gmail.com', 'NTI Ecommerce Website Verification');
                    $mail->addAddress($_POST['email'], $_POST['first']);     //Add a recipient

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Verification Code';
                    $mail->Body    = 'Your Verification Code is: <b>' . $code. '</b>';

                    $mail->send();
                    header('Location:checkCode.php?email=' . $_POST['email'] . '&forget=0');
                    echo 'Message has been sent';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }

            } else {
                // echo "Error";
                $errors['something'] = "<div class='alert alert-danger'>Something Went Wrong</div>";
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
                        <li><a href="index.php">Home</a></li>
                        <li class="active">Register</li>
                        <?php if(isset($errors['something'])) {echo $errors['something'];} ?>
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
                                    <h4> register </h4>
                                </a>
                            </div>
                            <div class="tab-content">
                                <div id="lg2" class="tab-pane active">
                                    <div class="login-form-container">
                                        <div class="login-register-form">
                                        <form method="post">
                                                <input type="text" name="first" placeholder="First Name" value="<?php if(isset($_POST['first'])){echo $_POST['first'];} ?>">
                                                <input type="text" name="last" placeholder="Last Name" value="<?php if(isset($_POST['last'])){echo $_POST['last'];} ?>">
                                                <input type="email" name="email" placeholder="Email" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>">
                                                <?php
                                                    if(!empty($email_validation)){
                                                        foreach($email_validation AS $key=>$value){
                                                            echo $value;
                                                        }
                                                    }

                                                    if(isset($emailChecked) && $emailChecked){
                                                        echo "<div class='alert alert-danger'>Email Already Registered, Please Login</div>";
                                                    }
                                                ?>
                                                <input type="tel" name="phone" placeholder="Phone" value="<?php if(isset($_POST['phone'])){echo $_POST['phone'];} ?>">
                                                <?php 
                                                    if(isset($phoneChecked) && $phoneChecked){
                                                        echo "<div class='alert alert-danger'>Phone Already Registered, Please Login</div>";
                                                    }
                                                ?>
                                                <input type="password" name="password" placeholder="Password">
                                                <input type="password" name="password_confirmation" placeholder="Confirm Password">
                                                <?php
                                                    if(!empty($password_validation)){
                                                        foreach($password_validation AS $key=>$value){
                                                            echo $value;
                                                        }
                                                    }
                                                ?>
                                                <select class="form-control" name="gender">
                                                    <option>---</option>
                                                    <option <?php if(isset($_POST['gender']) && $_POST['gender'] == 'f'){echo "selected";} ?> value="f">Female</option>
                                                    <option <?php if(isset($_POST['gender']) && $_POST['gender'] == 'm'){echo "selected";} ?> value="m">Male</option>
                                                </select>
                                                <br>
                                                <div class="button-box">
                                                    <button name="submit" type="submit"><span>Register</span></button>
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