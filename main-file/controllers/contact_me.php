<?php
include_once('./../connection/index.php');
require_once('./mail/PHPMailer.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$name = $_POST['name'];
	$last_name = $_POST['last_name'];
	$phone =  $_POST['phone'];
	$email = $_POST['email'];
	$type_contact = $_POST['type_contact'];
	$message = $_POST['message'];

	$sql = "INSERT INTO `contacts` (`name`, `last_name`, `email`, `phone`, `type_contact`, `message`) VALUES ('$name', '$last_name', '$email', '$phone', '$type_contact', '$message')";

	$query = mysqli_query($connection, $sql);

	if ($query) {
		$sqlSelect = mysqli_query($connection, "SELECT * FROM contacts ORDER BY id DESC LIMIT 1");

		while ($date = mysqli_fetch_array($sqlSelect)) {
			$name = $date['name'];
			$last_name = $date['last_name'];
			$phone = $date['phone'];
			$email = $date['email'];
			$type_contact = $date['type_contact'];
			$message = $date['message'];
		}
		$subject = "NUEVA SOLICITUD DESDE CORPORATIVO OVERALL";
		$mail->addAddress('bjimenez@overall.com.co');
		$mail->addAddress('cmesia@overall.com.co');

		$mail->Subject = $subject;
		$mail->Body = '
        <!DOCTYPE html
            PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" xmlns:box-shadow="http://www.w3.org/1999/xhtml">
        
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        </head>
        
        <body style="background-color:#eee;">
            <div
                style="background-color:#eee;margin:0;padding:0;font-family:Roboto,Arial,sans-serif;font-weight:500;color:#F0F0F0;font-size:16px;">
                <p>&nbsp;</p>
                <table style="width: 100%; border-collapse: collapse;" border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr style="font-size: 14px; color:#545f75">
                            <td>&nbsp;</td>
                            <td style="width: 600px;">
                                <table style="width: 100%; border-collapse: collapse;background-color: #fff;" border="0"
                                    cellspacing="0" cellpadding="0"> 
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div style="padding: 30px 0; text-align: center;background-color:#1e5fa4;">
                                                    <div><img src="https://i.imgur.com/IA6URai.png" alt="SVGator"
                                                            width="140" height="35" /></div>
                                                </div>
                                                <div style="line-height: 150%;">
                                                    <div style="padding: 60px 50px;">
                                                        <p style="margin: 20px 0; font-weight: 700;">¡Tienes un nuevo mensaje!</p>
                                                        <p style="margin: 20px 0;">Los datos del contacto son:</p>
                                                        <ul>
                                                         <li><b>Nombre completo: </b>' . $name . ' ' . $last_name . '</li>
                                                        <li><b>Correo: </b>' . $email . '</li>
                                                        <li><b>Motivo de Contacto: </b>' . $type_contact . '</li>
                                                        <li><b>Mensaje: </b>' . $message . '</li>
                                                        </ul>
        
                                                        <p style="margin: 20px 0 0;">Recuerda que esto es un correo automático, por favor no responder.</p>
        
                                                        <div style="margin: 45px 0; text-align:left;">
                                                            <a style="display: inline-block;text-decoration: none; background-color: #004e96; border: none; border-radius: 4px; color: #ffffff; font-size: 16px; line-height: 1; outline: none; text-align: center; padding: 13px 30px; font-weight: bold;"
                                                                href="https://overall.com.co/">Ir al portal</a>
                                                        </div>
        
                                                        <div style="margin: 0;">
                                                            <p style="margin:0; line-height: 150%;">Gracias por hacer parte de
                                                                nuestro equipo,<br /> Corporativo Overall</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr style="color: white; text-align: center;">
                            <td>&nbsp;</td>
                            <td style="">
                                <div style="color: #172032; line-height: 1.5; margin: 25px 0; font-size: 14px;">&copy; 2023
                                    Corporativo Overall. All rights reserved.<br /></div>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
        
                    </tbody>
                </table>
            </div>
        </body>
        
        </html>';

		$mail->send();
	} else {
		echo "Error: " . mysqli_error($connection);
	}
}
