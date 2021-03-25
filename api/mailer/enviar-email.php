
 <?php

	date_default_timezone_set('Etc/UTC');
	require '../PHPMailer/PHPMailerAutoload.php';
    
	$tituloEmail = "título";

	$message = 'mensagem';

	$mail= new PHPMailer;
	$mail->IsSMTP(); 
	$mail->CharSet = 'UTF-8';   
	$mail->SMTPDebug = 2;       // 0 = nao mostra o debug, 2 = mostra o debug
	$mail->SMTPAuth = true;     
	$mail->SMTPSecure = 'ssl';  
	$mail->Host = 'smtp.gmail.com'; 
	$mail->Port = 465; 
	$mail->Username = 'usuario-email-origem'; 
	$mail->Password = 'senha';
	$mail->SetFrom('email-origem', 'Nome Empresa');
	$mail->addAddress('email-destinatario','');
	$mail->Subject = $tituloEmail;
	$mail->msgHTML($message);
       
	$mail->send();

	// Configure o Gmail para permitir aplicativos de terceiro 
	// https://myaccount.google.com/lesssecureapps


?>
