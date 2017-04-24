<?php 

function sendEmail($data)
{
	require APP_ROOT . '/vendor/autoload.php';

	$mail = new PHPMailer();

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = SMTP_HOST;  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = SMTP_USER;                 // SMTP username
	$mail->Password = SMTP_PASSWORD;                           // SMTP password
	$mail->SMTPSecure = SMTP_ENCRYPTION;                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = SMTP_PORT;

	$mail->CharSet = 'UTF-8';


	$mail->setFrom("SMTP_FROM", "SMPT_USER_FROM");
	$mail->addAddress($data['email'], $data['name']);     // Add a recipient
	
	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = 'Você Solicitou a Recuperação de Senha';
	
	$home = HOME;

	$msg = "Olá {$data['name']}, tudo bem? <br>
		Para alterar sua senha <a href=\"{$home}/auth/atualizar-senha/{$data['token']}\">clique aqui</a>
		<hr>
		Email enviado em date('d/m/Y H:i:s')";

	$mail->Body = $msg;

	return $mail->send();
}