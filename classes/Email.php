<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {

        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {
        // Crear el objeto del mail
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'c6245119063e5f';
        $mail->Password = '178583a5e38e72';

        $mail->setFrom('cuentas@facilitadora-app-de-turnos.com.ar');
        $mail->addAddress('cuentas@facilitadora-app-de-turnos.com.ar', 'facilitadora-app-de-turnos.com.ar');
        $mail->Subject = 'Confirma tu Cuenta';

        // Utilizamos HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->email . "</strong> Has creado tu cuenta en Facilitadora App de Turnos,
        solo debes confirmarla haciendo click en el siguiente enlace.</p>";
        $contenido .= "<p>Presiona aquí: <a href= 'http://localhost:3000/confirmarCuenta?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje.</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        // Enviar el mail
        $mail->send();
    }

    public function enviarInstrucciones() {

        // Crear el objeto del mail
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'c6245119063e5f';
        $mail->Password = '178583a5e38e72';

        $mail->setFrom('cuentas@facilitadora-app-de-turnos.com.ar');
        $mail->addAddress('cuentas@facilitadora-app-de-turnos.com.ar', 'facilitadora-app-de-turnos.com.ar');
        $mail->Subject = 'Reestablece tu password';

        // Utilizamos HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has solicitado reestablecer tu password, sigue el siguiente enlace para hacerlo</p>";
        $contenido .= "<p>Presiona aquí: <a href= 'http://localhost:3000/recuperar?token=" . $this->token . "'>Reestablecer Password</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta acción, puedes ignorar el mensaje.</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        // Enviar el mail
        $mail->send();

    }
}
