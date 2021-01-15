<?php
require "login.php";
require "funciones.php";

$mensaje="";

if(isset($_POST["email"])){

    $conexion = new mysqli($hn, $un, $pw, $db,$port);

    $email=get_post($conexion,"email");

    $query = "SELECT * FROM usuario where correo='$email'";
	$result = $conexion->query($query);
    if ($result->num_rows){
		$usuario=$result->fetch_array();
		$correo=$usuario[5];
		$password=$usuario[7];

		$mensaje = '<a href="http://citamedicaunajma.byethost9.com/di/editpassword.php?hash='.
			$password.
			'&correo='.
			$correo.
			'">Cambiar Contraseña</a>';

		// Varios destinatarios
		$para  = $correo; 

		// título
		$título = 'Recuperar contraseña';

		// mensaje
		$mensaje = '<html>
			<head>
			<title>Recordatorio de cumpleaños para Agosto</title>
			</head>
			<body>'.
				$mensaje.
			'</body>
			</html>
			';

		$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";

		mail($para, $título, $mensaje, $cabeceras);

		$mensaje='
				<div class="card-head">
				<div class="alert alert-success" role="alert">
					Se envio el enlace de recuperación a su correo
				</div></div>
				';
	}else{
		$mensaje='
		<div class="card-head">
		<div class="alert alert-danger" role="alert">
			el correo no existe
		</div>
		</div>
		';
	}
    
}
?>
<!doctype html>
<html lang='es'>
<head>
	<meta charset='UTF-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0, minimum-scale=1.0'>
	<title>Document</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" >
</head>
<body>

<div class="container">
	<div class="row">
		<div class="col col-12">
			<h1>Recuperar Contraseña</h1>
		</div>
		<div class="col col-12">
			<div class="card">
				<?php echo $mensaje?>
				<div class="card-body">
					<form action="recuperar.php" method="post">
						<div class="form-group">
							<label for="email"></label>
							<input type="email" class="form-control" id="email" name="email">
						</div>
				
						<button type="submit" class="btn btn-primary">Recuperar</button>
					
					</form>
				</div>
				<div class="card-footer">
					<p>¿Todavía no tienes una cuenta? <a href="registro.php">Registrarme</a>.</p>
					<p>¿Ya tienes una cuenta? <a href="index.php">Iniciar Sesión</a>.</p>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" ></script>
</body>
</html>
