<html>
	<head>
		<meta charset="utf-8" />
    	<title>App Mail Send</title>

    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    	<?php  
    	session_start();
    	//require 'processa_envio.php';
    	?>
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
  				
					<div class="card-body font-weight-bold">
						<form action="processa_envio.php" method="post">
							<div class="form-group">
								<label for="para" >Para</label>
								<input type="text" name="para" class="form-control" id="para" placeholder="joao@dominio.com.br">
							</div>
							<div class="form-group">
								<label for="cc" >CC</label>
								<input type="text" name="cc" class="form-control" id="cc" placeholder="vitor@dominio.com.br">
							</div>
							<div class="form-group">
								<label for="cc2" >CC2</label>
								<input type="text" name="cc2" class="form-control" id="cc2" placeholder="maria@dominio.com.br">
							</div>

							<div class="form-group">
								<label for="assunto">Assunto</label>
								<input type="text" name="assunto" class="form-control" id="assunto" placeholder="Assundo do e-mail">
							</div>

							<div class="form-group">
								<label for="mensagem">Mensagem</label>
								<textarea name="mensagem" class="form-control" id="mensagem"></textarea>
								<?php 
								if (isset($_GET['login']) and $_GET['login'] == 'erro') { ?>
								<div class="text-danger">
									Preencha todos os campos!
								</div> <?php } ?>
							</div>
							
							<button type="submit" class="btn btn-primary btn-lg">Enviar Mensagem</button>
							
						</form>
					</div>
				</div>
      		</div>
      	</div>

	</body>
</html>