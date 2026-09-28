<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Require Composer's autoloader (if using Composer)
require 'vendor/autoload.php';

$error = "";
$successMessage = "";

if ($_POST) {
    if (empty(trim($_POST["name"]))) {
        $error .= "A name address is required.<br>";
    }

    if (empty(trim($_POST["email"]))) {
        $error .= "An email address is required.<br>";
    }



    //  Check target recipient email
    if (empty(trim($_POST["to_email"]))) {
        $error .= "Recipient email address is required.<br>";
    }


    if (empty(trim($_POST["subject"]))) {
        $error .= "A Subject is required.<br>";
    }
    if (empty(trim($_POST["msg"]))) {
        $error .= "Write your email. This field is required.<br>";
    }

    if (!empty($_POST["email"]) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
        $error .= "Email address is invalid.<br>";
    }

    // Validate attachment upload status
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] !== UPLOAD_ERR_NO_FILE) {
            if ($_FILES['attachment']['error'] === UPLOAD_ERR_INI_SIZE || $_FILES['attachment']['error'] === UPLOAD_ERR_FORM_SIZE) {
                $error .= "The attached file is too large.<br>";
            } elseif ($_FILES['attachment']['error'] !== UPLOAD_ERR_OK) {
                $error .= "An error occurred during file upload.<br>";
            }
        }




    if ($error != "") {
        $error = '<div class="alert alert-danger" role="alert"><p>There were errors in your form</p>' . $error . '</div>';
    } else {
        $mail = new PHPMailer(true);

        try {
            // Server settings (Example using Mailtrap for testing)
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Replace with your SMTP host (e.g., smtp.gmail.com)
            $mail->SMTPAuth   = true;
            $mail->Username   = '';   // Replace with your SMTP username
            $mail->Password   = '';   // Replace with your SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use 'tls' or 'ssl'
            $mail->Port       = 587; // Use 587 for Gmail, 465 for SSL



           
            // Recipients
            $mail->setFrom('', 'Website Contact Form');
            // DYNAMIC DESTINATION: Sent to whatever email was entered in the form
            $mail->addAddress($_POST['to_email']);
            $mail->addReplyTo($_POST['email'], $_POST['name']);




             // Attach file if uploaded without errors
                if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
                    $uploadFilePath = $_FILES['attachment']['tmp_name'];
                    $uploadFileName = $_FILES['attachment']['name'];
                    $mail->addAttachment($uploadFilePath, $uploadFileName);
                }




            // Content
            $mail->isHTML(false);
            $mail->Subject = $_POST['subject'];
            $mail->Body    = "Name: " . $_POST['name'] . "\n" . 
                             "Sender Email: " . $_POST['email'] . "\n\n" . 
                             "Message:\n" . $_POST['msg'];

            $mail->send();
            $successMessage = '<div class="alert alert-success" role="alert">Your Message was sent. We\'ll get back to you ASAP!</div>';
        } catch (Exception $e) {
            $error = '<div class="alert alert-danger" role="alert">Message could not be sent. Mailer Error: ' . $mail->ErrorInfo . '</div>';
        }
    }
}

// ADD THIS AT THE VERY BOTTOM OF THE FILE
echo $error;
echo $successMessage;




?>