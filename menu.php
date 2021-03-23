<?php
session_start();
if(!isset($_SESSION['nombre']))
{
	header("Location: index.php");
}
else
{
?>

<html>
	<head>
		<meta charset="UTF-8">
		<title>SystemApp - Menú</title>
	</head>
	<body>
		<h1>Menú SistemApp</h1>
		<ul>
			<li><a href="#">Inicio</a></li>
			<li><a href="listarUsuarios.php">Listado usuarios</a></li>
			<li><a href="panelControl.php">Panel de control</a></li>
			<li><a href="cerrarSesion.php">Cerrar sesión</a></li>
		</ul>
	</body>
<?php 
	echo "Te has identificado como <b>" . $_SESSION['nombre'] . "</b>";
}
?>
</html>