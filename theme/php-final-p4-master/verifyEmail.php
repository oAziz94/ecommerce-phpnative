<?php 
include_once "header.php";
include_once "php/User.php";
include_once "php/validation.php";
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
    $validation->setEmail($_POST['email']);
    $emailValidation = $validation->emailValidation();
    if(empty($emailValidation)){
        // check on email if exists in db
        $emailChecked = new user;
        $emailChecked->setEmail($_POST['email']);
        $result = $emailChecked->checkEamil();
        if($result){
            // generate new code
            $code = rand(99999,10000);
            // save code
            $emailChecked->setCode($code);
            $result2 = $emailChecked->updateCode();
            if($result2){
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
                    $mail->addAddress($_POST['email']);     //Add a recipient


                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Verification Code';
                    $mail->Body    = 'Your Verifcation Code is:<b>' . $code . '</b>';

                    $mail->send();
                    // echo 'Message has been sent';
                    header('Location:checkCode.php?email=' . $_POST['email'].'&forget=1');
                    // hello world
                    // nti
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }else{
                $errors['someThing'] = "<div class='alert alert-danger'> Something Went Wrong </div>";
            }

        }else{
            $errors['email'] = "<div class='alert alert-danger'> This email dosen't Exists in our records </div>";
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
                                        <input type="Email" name="email" placeholder="Email">
                                        <?php
                                                 if(!empty($emailValidation)){
                                                        foreach($emailValidation AS $key=>$Value){
                                                            echo $Value;
                                                        }
                                                    }
                                                if(!empty($errors)){
                                                    foreach($errors AS $key=>$Value){
                                                        echo $Value;
                                                    }
                                                }
                                        ?>
                                        <br><br>
                                        <div class="button-box">
                                            <button name='submit'><span>Verify</span></button>
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