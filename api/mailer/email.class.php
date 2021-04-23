 <?php

	date_default_timezone_set('Etc/UTC');
	require 'PHPMailer/PHPMailerAutoload.php';
    
	class Email {
	
		public function send($title, $message, $to) {

			$mail= new PHPMailer;
			$mail->IsSMTP(); 
			$mail->CharSet = 'UTF-8';   
			$mail->SMTPDebug = 0;       // 0 = nao mostra o debug, 2 = mostra o debug
			$mail->SMTPAuth = true;     
			$mail->SMTPSecure = 'ssl';  
			$mail->Host = 'smtp.gmail.com'; 
			$mail->Port = 465; 
			$mail->Username = 'bsi.video.verifica@gmail.com'; 
			$mail->Password = 'pucpr2021';
			$mail->SetFrom('bsi.video.verifica@gmail.com', 'Bsi Video');
			$mail->addAddress($to, 'Usuario');
			$mail->Subject = $title;
			$mail->msgHTML($message);
			
			$mail->send();
		}

	// Configure o Gmail para permitir aplicativos de terceiro 
	// https://myaccount.google.com/lesssecureapps

	}
?>
