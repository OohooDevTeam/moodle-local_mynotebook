<?php


	$send= new email();
$body=$_POST['']
$send->enviar_correo($body,$subject,$email,"example@mydomain.com");
class email
{
	function enviar_correo($body,$subject,$email,$emaildestino)
	{
	include_once('Mail.php');
    $mail = Mail::factory("mail");
    $headers = array("From"=>"email@example.com", "Subject"=>"$subject", "Reply-To"=>"$email");
	$body = "This is a test!";
    $mail->send($emaildestino, $headers, $body);
    
	}
	function responder($email,$subject,$mensaje)
	{
		$mensaje = wordwrap($mensaje, 800);
				mail($email,$subject,$mensaje);
	}
}	
?>