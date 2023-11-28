<?php 
namespace Clasess;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Email {

    public $email;
    public $nombre ;
    public $token;
    public function __construct($email , $nombre , $token) {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }
    //confirmar
    public function enviarConfirmacion(){
        //Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '8f2a797254d177';
        $mail->Password = '9d1ed455c8a8d1';
        $mail->SMTPSecure = 'tls';

        $mail->setFrom("Cuentas@appsalon.com","Appsalon");
        $mail->addAddress("Cuentas@appsalon.com","Apsalon.com");
        $mail->Subject = "Confirma tu cuenta";

        //set html
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido ="<html>";
        $contenido.= "<p><strong>Hola " . $this->nombre ."</strong>  Has Creado tu cuenta en appsalon,confirma tu cuenta presionando el siguiente enlance</p>";
        $contenido .= "<p>Presiona aqui: <a href=' " .$_ENV['PROJECT_URL']. "/confirmar_cuenta?token=".$this->token."'>Confirma tu cuenta</a> <p>";
        $contenido.= "<p>Si tu no solicitaste crear esta cuenta puedes ignorar el mensaje.</p>";
        $contenido.="</html>";

        $mail->Body = $contenido;
     
        if($mail->send()){
            $mensaje = 'Hubo un Error... intente de nuevo';
        } else {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

}
//olvide mi password
    public function enviarInstrucciones(){
         //Crear el objeto de email
         $mail = new PHPMailer();
         $mail->isSMTP();
         $mail->Host = $_ENV['EMAIL_HOST'];
         $mail->SMTPAuth = true;
         $mail->Port =  $_ENV['EMAIL_PORT'];
         $mail->Username =  $_ENV['EMAIL_USER'];
         $mail->Password =  $_ENV['EMAIL_PASS'];
         $mail->SMTPSecure = 'tls';
 
         $mail->setFrom("Cuentas@appsalon.com","Appsalon");
         $mail->addAddress("Cuentas@appsalon.com","Apsalon.com");
         $mail->Subject = "Restablecer password";
 
         //set html
         $mail->isHTML(true);
         $mail->CharSet = 'UTF-8';
 
         $contenido ="<html>";
         $contenido.= "<p><strong>Hola " . $this->nombre ."</strong> Has solicitado restablecer tu password sigue los siguientes pasos para hacerlo</p>";
         $contenido .= "<p>Presiona aqui: <a href='" .$_ENV['PROJECT_URL']. "/recuperar_password?token=". $this->token ."'>Restablecer password</a> <p>";
         $contenido.= "<p>Si tu no solicitaste crear esta cuenta puedes ignorar el mensaje.</p>";
         $contenido.="</html>";
 
         $mail->Body = $contenido;
      
         if($mail->send()){
             $mensaje = 'Hubo un Error... intente de nuevo';
         } else {
             echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
         }

    }
}