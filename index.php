<?php
include 'sqlConfig.php';
session_start();

if (isset($_SESSION['nombre'])) 
{
	header("Location: inicio.php");
}
if (isset($_POST['login']))
{
	$username = $_POST['username'];
	$password = $_POST['password'];
	$con="SELECT * FROM LOGIN WHERE username='$username'";

	$consulta=mysqli_query($conexion,$con);
	$fila = mysqli_fetch_array($consulta);
	if (!$fila)
	{
		$usuarioError = true;
	}
	else
	{
		if (password_verify($password, $fila['password']))
	    {
	    	$_SESSION['nombre']=$username;
	    	$consulta=mysqli_query($conexion,"SELECT * FROM LOGIN WHERE username='$username'");
	    	$fila = mysqli_fetch_array($consulta);
	    	$_SESSION['email']= $fila['email'];
	    	$_SESSION['cod']= $fila['cod'];
	      	header("Location: inicio.php");
	    }
	    else
	    {
	    	$logError = true;
	    }
	}
}

mysqli_close();
?>

<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="Expires" content="0">
		<meta http-equiv="Last-Modified" content="0">
		<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
		<meta http-equiv="Pragma" content="no-cache">
		<title>SystemApp - Login</title>
		<link rel="stylesheet" type="text/css" href="css/errores.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="css/login.css" media="screen" />
	</head>
	<body>
		<img class="logo" src="images/logo.png" /><br><br><br><br><br><br><br><br><br>
		<h1>Bienvenido a SistemApp</h1>
		<form method="post" action="" name="formulario_login">
			<div class="form-element">
				<label>Nombre de usuario</label>
				<input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
				<?php if($usuarioError){ echo '<p class="error">No se encuentra el usuario</p>';  } ?>
			</div>
			<div class="form-element">
				<label>Contraseña</label>
				<input type="password" name="password" required />
			</div>
			<button type="submit" name="login" value="login">Iniciar sesión</button>
			<a href="registrar.php">Registrar cuenta</a><br>
			<?php if($logError){ echo '<p class="error">La combinación usuario-contraseña introducida es incorrecta</p>';  } ?>
		</form>
	</body>
</html>