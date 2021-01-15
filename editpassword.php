<?php
require "login.php";
require "funciones.php";
if(isset($_GET["hash"]) and isset($_GET["correo"])){

    $conexion = new mysqli($hn, $un, $pw, $db,$port);

    $hash=get_get($conexion,"hash");
    $correo=get_get($conexion,"correo");

    $query = "SELECT * FROM usuario where correo='$correo' and password='$hash'";

    $result = $conexion->query($query);
    
    if ($result->num_rows){
		//$usuario=$result->fetch_array();
        //print_r($usuario);
        echo <<<EOT
        <!doctype html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0, minimum-scale=1.0'>
            <title>Document</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" >
        </head>
        <body class="bg-light">

        <div class="container">
            <div class="row">
                <div class="col col-12">
                    <h1>Cambiar Contraseña</h1>
                </div>
                <div class="col col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="editpassword.php" method="post">
                                <input type="hidden" value="$hash" name="hash">
                                <input type="hidden" value="$correo" name="correo">
                                <div class="form-group">
                                    <label for="pass">Contraseña Nueva</label>
                                    <input type="password" class="form-control" id="pass"  name="password">
                                </div>

                                <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                            
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
        EOT;
    }
}

if(isset($_POST["hash"]) and isset($_POST["correo"]) and isset($_POST["password"])){
    $conexion = new mysqli($hn, $un, $pw, $db, $port);
	if ($conexion->connect_error) {
		die("Fatal Error");
	}
	
	$hash=get_post($conexion,"hash");
    $correo=get_post($conexion, "correo");
    $password=get_post($conexion, "password");
	$password=md5($password);

	$query = "UPDATE usuario set password='$password' where password='$hash' and correo='$correo'";
	$result = $conexion->query($query);
	if ($result){
        echo "se actualizó";
    }else{
        echo "error al acualizar";
    }
}
?>
