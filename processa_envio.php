<?php  
	require 'bibliotecas/PHPMailer/Exception.php';
	require 'bibliotecas/PHPMailer/OAuth.php';
	require 'bibliotecas/PHPMailer/PHPMailer.php';
	require 'bibliotecas/PHPMailer/POP3.php';
	require 'bibliotecas/PHPMailer/SMTP.php';
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception; 
	use PHPMailer\PHPMailer\SMTP;
	session_start();
	class Mensagem{
		private $para = null;
		private $cc = null;
		//private $cc2 = null;
		private $assunto = null;
		private $mensagem = null;
		public $status = array('codido_status' => null, 'descriçao_status' => ''); 
		public function  __get($atributo){
			return $this->$atributo;
		}
		public function __set($atributo, $value){
			$this->$atributo = $value;
		}
		public function mensagemValida(){
			if(empty($this->para) or empty($this->assunto) or empty($this->mensagem)){
				return false;
			}
			return true;
		}
	}
	$mensagem = new Mensagem();
	$mensagem->__set('para', $_POST['para']);
	$mensagem->__set('cc', $_POST['cc']);
	//$mensagem->__set('cc2', $_POST['cc2']);
	$mensagem->__set('assunto', $_POST['assunto']);
	$mensagem->__set('mensagem', $_POST['mensagem']);
	//print_r($mensagem);
	if(!$mensagem->mensagemValida()){
		echo 'mensagem não é valida';
		$_SESSION['valida'] = 'NÃO';
		header('Location: index.php?login=erro');
	}else{
		$_SESSION['valida'] = 'SIM';
	}
	
	$mail = new PHPMailer(true);

	try {
    //Server settings
	   $mail->SMTPDebug = false;                      //Enable verbose debug output
	    $mail->isSMTP();                                            //Send using SMTP
	    $mail->Host  = 'smtp.gmail.com';                     //Set the SMTP server to send through
	    $mail->SMTPAuth = true;                               //Enable SMTP authentication
	    $mail->Username = 'vinifreitas107@gmail.com';         //SMTP username
	    $mail->Password= 'flamengo.';                         //SMTP password
	    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
	    $mail->Port = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

	    //Recipients
	    $mail->setFrom('vinifreitas107@gmail.com', 'Vinicius Freitas');
	    $mail->addAddress($mensagem->__get('para'));     //Add a recipient
	    $mail->addAddress($mensagem->__get('cc'));               //Name is optional
	    //$mail->addAddress($mensagem->__get('cc2'));               //Name is optional
	    //$mail->addAddress('vinifreitas74@hotmail.com');               //Name is optional
	    //$mail->addReplyTo($mensagem->__get('cc'));
	    //$mail->addCC('cc@example.com');
	    //$mail->addBCC('bcc@example.com');
	    //Attachments
	    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
	    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

	    //Content
	    $mail->isHTML(true);                                  //Set email format to HTML
	    $mail->Subject = $mensagem->__get('assunto');
	    $mail->Body    = $mensagem->__get('mensagem');
	    $mail->AltBody = 'É necessário utilizar um Client que suporte HTML para ter acesso ao conteúdo completo do email';

	    $mail->send();
	    $mensagem->status['codido_status'] = 1;
	    $mensagem->status['descriçao_status'] = 'Email enviado com sucesso';
	    
	} catch (Exception $e) {
    	$mensagem->status['codido_status'] = 2;
	    $mensagem->status['descriçao_status'] = "Não foi possível enviar esse email! Tente novamente mais tarde {$mail->ErrorInfo}";
	    $erro = $mail->ErrorInfo . PHP_EOL;
	    $arquivo = fopen('../../sendmail/erro.txt', 'a');
	    fwrite($arquivo, $erro);
	    fclose($arquivo);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>SendMail</title>
	<meta charset="utf-8" />
    	<title>App Mail Send</title>

    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    	
</head>
<body>
	<div class="container">
		<div class="py-3 text-center">
				<img class="d-block mx-auto mb-2" src="logo.png" alt="" width="72" height="72">
				<h2>Send Mail</h2>
				<p class="lead">Seu app de envio de e-mails particular!</p>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?php 
					if($mensagem->status['codido_status'] == 1){?>
						<div class="container">
							<h1 class="display-4 text-success"> Sucesso</h1>
							<p><?= $mensagem->status['descriçao_status'] ?></p>
							<a href="index.php" class="btn btn-success btn-lg mt-5 text-white">Voltar</a>
						</div>
					<?php }else{?>
						<div class="container">
							<h1 class="display-4 text-danger">Ops!</h1>
							<p><?= $mensagem->status['descriçao_status'] ?></p>
							<a href="index.php" class="btn btn-warning btn-lg mt-5 text-white">Voltar</a>
						</div>
					<?php } ?> 
				</div>
			</div>
	</div>
</body>
</html>