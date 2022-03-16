<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->setLanguage('ru', 'phpmailer/language/');
$mail->IsHTML(true);

// from who
$mail->setFrom('info@writingor.net', 'Form from site');
// to
$mail->addAdress('writingornet@gmail.com');
// title
$mail->Subject = "Hi! This is form from site"

// landing page
$typeOfLandingPage = "standart";
if($_POST['landingOption'] == "premium") {
    $typeOfLandingPage = "premium";
}

// body
$body = '<h1>This is a mail</h1>'

if (trim(!empty($__POST['customerName']))) {
    $body.='<p><strong>Name:</strong> '.$_POST['customerName'].'</p>';
}

if (trim(!empty($__POST['customerEmail']))) {
    $body.='<p><strong>E-mail:</strong> '.$_POST['customerEmail'].'</p>';
}

if (trim(!empty($__POST['landingOption']))) {
    $body.='<p><strong>Type of langing page:</strong> '.$typeOfLandingPage.'</p>';
}

if (trim(!empty($__POST['deadline']))) {
    $body.='<p><strong>Deadline:</strong> '.$_POST['deadline'].'</p>';
}

if (trim(!empty($__POST['mailFormMessage']))) {
    $body.='<p><strong>Message:</strong> '.$_POST['mailFormMessage'].'</p>';
}


// attach file
if (!empty($_FILES['image']['tmp_name'])) {
    //path
    $filePath = __DIR__ . "/files/" . $_FILES['image']['name'];
    // upload
    if (copy($_FILES['image']['tmp_name'], $filePath)) {
        $fileAttach = $filePath;
        $body.='<p><strong>Attachment:</strong></p>';
        $mail->addAttachment($fileAttach);
    }
}

$mail->Body = $body;

//send
if (!$mail->send()) {
    $message = "Error.";
} else {
    $message = "Mail sent";
}

$response = ['message' => $message];

header('Content-type: application/json');
echo json_encode($response);


?>