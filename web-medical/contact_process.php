<?php
use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Mailer = "smtp";

//Configuracion servidor mail

$mail->SMTPDebug = 1;

$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls'; //seguridad

$mail->Host = "SERVER-SMTP"; // servidor smtp

$mail->Port = 587; //puerto
$mail->Username = 'USER';
$mail->Password = 'PASS';

$from = $_REQUEST['email'];
$name = $_REQUEST['name'];
$csubject = $_REQUEST['subject'];
//$number = $_REQUEST['number'];
$cmessage = $_REQUEST['message'];

$headers = "From: $from";
$headers = "From: " . $from . "\r\n";
$headers .= "Reply-To: " . $from . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$subject = "Medic@l mensaje de contacto.";

$logo = 'img/logo.png';
$link = '#';

$body = "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title>Express Mail</title></head><body>";
$body .= "<table style='width: 100%;'>";
$body .= "<thead style='text-align: center;'><tr><td style='border:none;' colspan='2'>";
$body .= "<a href='{$link}'><img src='{$logo}' alt=''></a><br><br>";
$body .= "</td></tr></thead><tbody><tr>";
$body .= "<td style='border:none;'><strong>Name:</strong> {$name}</td>";
$body .= "<td style='border:none;'><strong>Email:</strong> {$from}</td>";
$body .= "</tr>";
$body .= "<tr><td style='border:none;'><strong>Subject:</strong> {$csubject}</td></tr>";
$body .= "<tr><td></td></tr>";
$body .= "<tr><td colspan='2' style='border:none;'>{$cmessage}</td></tr>";
$body .= "</tbody></table>";
$body .= "</body></html>";

//$send = mail($to, $subject, $body, $headers);
$mail->IsHTML(true);

$to = "sistemamedical.info@gmail.com";
$from = "taiya04@twinducedz.com";
//Agregar destinatario
$mail->AddAddress($to);
$mail->SetFrom($from, "Medic@l");

$mail->Subject = $subject;
$mail->Body = $body;

//Avisar si fue enviado o no y dirigir al index
$output = $mail->Send() ? '{"success":1, "msg": "Gracias por comunicarte con nosotros. Te responderemos lo mas pronto posible."}' : '{"success":0, "msg": "No se ha podido enviar tu mensaje, por favor intentalo nuevamente."}';

// Clean output buffer
if (ob_get_length()) {
    ob_end_clean();
}
header('Access-Control-Allow-Origin: *'); //Permitir cross-domain
//header("Content-Type: application/json");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
echo $output;
