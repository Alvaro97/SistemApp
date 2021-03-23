<?php
include 'sqlConfig.php';
session_start();

if (isset($_SESSION['nombre'])) 
{
	header("Location: menu.php");
}
if (isset($_POST['register']))
{
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $consultaEmail=mysqli_query($conexion,"SELECT * FROM LOGIN WHERE email='$email'");
    $consultaUsuario=mysqli_query($conexion,"SELECT * FROM LOGIN WHERE username='$username'");

    if(!empty($consultaEmail) AND mysqli_num_rows($consultaEmail)>0)
    {
        $errorEmail = true;
    }
    if(!empty($consultaUsuario) AND mysqli_num_rows($consultaUsuario)>0)
    {
        $errorUsuario = true;
    }
    if(!$errorEmail AND !$errorUsuario)
    {
		$con="INSERT INTO LOGIN (username,email,password) VALUES ('$username','$email','$password_hash')";
		$consulta=mysqli_query($conexion,$con);
		if ($consulta)
		{
			$_SESSION['nombre'] = $username;
			$_SESSION['email'] = $email;
			$consulta=mysqli_query($conexion,"SELECT * FROM LOGIN WHERE username='$username'");
	    	$fila = mysqli_fetch_array($consulta);
			$_SESSION['cod'] = $fila['cod'];
			header("Location: menu.php");
		}
		else
		{
			$errorRegistro = true;
		}
	}
}
mysqli_close();
?>

<html>
	<head>
		<meta charset="UTF-8">
		<title>SystemApp - Registro</title>
		<link rel="stylesheet" type="text/css" href="css/errores.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="css/login.css" media="screen" />
	</head>
	<body>
		<img class="logo" src="images/logo.png" /><br><br><br><br><br><br><br><br><br>
		<h1>Registro de usuario</h1>
		<form method="post" action="" name="formulario_registro">
			<div class="form-element">
		        <label>Nombre de usuario</label>
		        <input type="text" name="username" pattern="[a-zA-Z0-9]+" required /> <?php if($errorUsuario){ echo '<p class="error">El usuario ya existe</p>'; } ?>
		    </div>
		    <div class="form-element">
		        <label>Email</label>
		        <input type="email" name="email" required /> <?php if($errorEmail){ echo '<p class="error">El email ya existe</p>'; } ?>
		    </div>
		    <div class="form-element">
		        <label>Password</label>
		        <input type="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Debe contener al menos un número y una letra minúscula y mayúscula, y al menos 8 o más caracteres" required />
		    </div>
		    <button type="submit" name="register" value="register">Registrar</button>
		    <a href="index.php">Volver</a><br>
		    <?php if($errorRegistro){ echo '<p class="error">No se ha podido registrar al usuario. Inténtalo de nuevo</p>'; } ?>
		</form>
	</body>
</html>