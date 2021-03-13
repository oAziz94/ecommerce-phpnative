<?php 

include_once 'header.php';
include_once 'php/User.php';
include_once 'php/validation.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

if(isset($_POST['verify'])){
    $errors = [];
    $validation = new validation;
    $validation->setEmail($_POST['email']);
    $emailValidation = $validation->emailValidation();
    if(empty($emailValidation)){
        $emailExists = new User;
        $emailExists->setEmail($_POST['email']);
        $result = $emailExists->checkEmail();
        if($result){
            $code = rand(99999, 10000);
            $emailExists->setCode($code);
            $result2 = $emailExists->updateCode();
            if($result2){
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
                    $mail->addAddress($_POST['email']);     //Add a recipient

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Verification Code';
                    $mail->Body    = 'Your Verification Code is: <b>' . $emailExists->getCode() . '</b>';

                    $mail->send();
                    header('Location:checkCode.php?email=' . $emailExists->getEmail()  . '&forget=1');
                    echo 'Message has been sent';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                echo "<div class='alert alert-danger>Something Went Wrong</div>";
            }
        } else {
            $errors['email'] = "<div class='alert alert-danger'>This Email does not exist in our records</div>";
        }
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
                            <h4> Verify Your Email </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg2" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form method="post">
                                        <input type="email" name="email" placeholder="Enter Your Registered Email">
                                        <?php
                                            if(!empty($emailValidation)){
                                                foreach($emailValidation AS $key=>$value){
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
                                            <button name="verify" type="submit"><span>Verify</span></button>
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