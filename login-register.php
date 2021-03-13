<?php 
include_once 'header.php';
include_once 'php/User.php';
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

if(isset($_POST['submit'])){
    $errors = [];
    if($_POST['email'] && $_POST['password']){
        $user = new User;
        $user->setEmail($_POST['email']);
        $user->setPassword($_POST['password']);
        $result = $user->login();
        if($result){
            $user = $result->fetch_object();
            if($user->status == 1){
                $_SESSION['user'] = $user;
                header("Location:index.php");
            } elseif($user->status == 2){
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
                    $mail->addAddress($_POST['email'], $user->f_name);     //Add a recipient

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Verification Code';
                    $mail->Body    = 'Your Verification Code is: <b>' . $user->code . '</b>';

                    $mail->send();
                    header('Location:checkCode.php?email=' . $user->email  . '&forget=0');
                    echo 'Message has been sent';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }
        }
    } else {
        $errors['fields'] = "<div class='alert alert-danger'> All Fields Required</div>";
    }
}
?>
        <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area bg-image-3 ptb-150">
            <div class="container">
                <div class="breadcrumb-content text-center">
					<h3>LOGIN</h3>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li class="active">Login</li>
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
                                    <h4> login </h4>
                                </a>
                            </div>
                            <div class="tab-content">
                                <div id="lg1" class="tab-pane active">
                                    <div class="login-form-container">
                                        <div class="login-register-form">
                                            <form method="post">
                                                <input type="email" name="email" placeholder="Email">
                                                <input type="password" name="password" placeholder="Password">
                                                <div class="button-box">
                                                    <div class="login-toggle-btn">
                                                        <a href="verify-email.php">Forgot Password?</a>
                                                    </div>
                                                    <button name="submit" type="submit"><span>Login</span></button>
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