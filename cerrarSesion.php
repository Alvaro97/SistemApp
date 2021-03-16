<?php
session_start();

if(!isset($_SESSION['nombre']))
{
	header("Location: index.php");
}
else
{
	session_destroy();
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8"/>
		<title>SistemApp - Cerrar Sesion</title>
		<link rel="stylesheet" type="text/css" href="formularios.css" media="screen" />
	</head>
	<body>
		<div class="form-element">
			<h2>Has cerrado sesion correctamente</h2>
			<br/>
			<button><a href="index.php">Ir a la página principal</a></button>
		</div>
	</body>
</html>