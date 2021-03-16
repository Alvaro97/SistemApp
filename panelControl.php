<?php
include 'sqlConfig.php';
session_start();
$cod = $_SESSION['cod'];

if(!isset($_SESSION['nombre']))
{
	header("Location: index.php");
}
else
{
	if(isset($_POST['nombreBoton']))
	{
		$username = $_POST['username'];
		$consulta = mysqli_query($conexion,"SELECT * FROM LOGIN");
		if(empty($consultaUsuario) AND mysqli_num_rows($consultaUsuario)<=0)
	    {
	    	while($fila = mysqli_fetch_array($consulta) AND !$errorUsuario)
	    	{
	    		if($fila['username'] == $username)
	    		{
	    			$errorUsuario=true;
	    		}
	    	}
	    }
	    if(!$errorUsuario)
	    {
	    	$consultaUsuario=mysqli_query($conexion,"SELECT * FROM LOGIN WHERE username='$username'");
	    	$fila = mysqli_fetch_array($consultaUsuario);
	    	if(strcmp($username, $fila['username'])==0)
	    	{
	    		$usuariosIguales=true;
	    	}
	    	else
	    	{
	    		$query="UPDATE LOGIN SET username='" . $username . "' WHERE cod=" . $cod;
	
				if (mysqli_query($conexion,$query))
				{
					setcookie('usuarioCreado', '1', 0);
					$_SESSION['nombre'] = $username;
					header("Location: panelControl.php");
				}
				else
				{
					echo '<p class="error">No se ha podido modificar el usuario</p>';
				}
	    	}
	    }
	}
	if(isset($_POST['emailBoton']))
	{
		$email = $_POST['email'];
		$consulta = mysqli_query($conexion,"SELECT * FROM LOGIN");
		
		if(empty($consultaUsuario) AND mysqli_num_rows($consultaUsuario)<=0)
	    {
	        while($fila = mysqli_fetch_array($consulta) AND !$errorUsuario)
	    	{
	    		if($fila['email'] == $email)
	    		{
	    			$errorEmail = true;
	    		}
	    	}
	    }
	    if(!$errorEmail)
	    {
	    	$consultaEmail = mysqli_query($conexion,"SELECT * FROM LOGIN");
	    	$fila = mysqli_fetch_array($consultaEmail);
	    	if(strcmp($email, $fila['email'])==0)
	    	{
	    		$emailIguales=true;
	    	}
	    	else
	    	{
	    		$query="UPDATE LOGIN SET email='" . $email . "' WHERE cod=" . $cod;

				if (mysqli_query($conexion,$query))
				{
					setcookie('emailCreado', '1', 0);
					$_SESSION['email'] = $email;
					header("Location: panelControl.php");
				}
				else
				{
					echo '<p class="error">No se ha podido modificar el email</p>';
				}
	    	}
	    }
	}
	if(isset($_POST['cambiar']))
	{
		$actualPassword = $_POST['passActual'];
		$newPassword = $_POST['passNueva'];
		$confirmPassword = $_POST['passConfirmar'];
		$username = $_SESSION['nombre'];
		$consultaPassword = mysqli_query($conexion, "SELECT * FROM LOGIN WHERE cod='$cod'");
		$fila = mysqli_fetch_array($consultaPassword);
		if (password_verify($actualPassword, $fila['password']))
		{
			if(strcmp($newPassword, $confirmPassword)==0)
			{
				$password_hash = password_hash($newPassword, PASSWORD_BCRYPT);
				$query = "UPDATE LOGIN SET password='" . $password_hash . "' WHERE cod=" . $cod;
				if(mysqli_query($conexion, $query))
				{
					$passwordMod = 1;
				}
				else
				{
					echo '<p class="error">Ha ocurrido un error</p>';
				}
			}
			else
			{
				$passwordDistintas = true;
			}
		}
		else
		{
			$passwordError = true;
		}
	}
?>

<html>
	<head>
		<meta charset="UTF-8">
		<title>SystemApp - Panel de Control</title>
		<link rel="stylesheet" type="text/css" href="css/popup.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="css/errores.css" media="screen" />
	</head>
	<body>
		<h1>Panel de Control</h1>
		<h3>Datos del usuario administrador</h3>
		<div>
			<form method="post" action="" name="formulario_configuracion_nombre">
				<div>
			        <label>Nombre de usuario</label>
			        <?php
			        echo '<input type="text" name="username" pattern="[a-zA-Z0-9]+" value="' . $_SESSION['nombre'] . '" required />';
			        echo '<button type="submit" name="nombreBoton" value="nombreBoton">Guardar</button>';
			        if($usuariosIguales){ echo '<p class="error">No has cambiado el nombre de usuario</p>'; }
			        elseif($errorUsuario){ echo '<p class="error">El usuario ya existe</p>'; }
			        elseif($_COOKIE['usuarioCreado']==1)
			        {
			        	echo '<p class="exito">Has modificado el nombre de usuario</p>';
			        	setcookie('usuarioCreado', '0', 0);
			        }
			        ?>
			    </div>
			</form>
			<form method="post" action="" name="formulario_configuracion_email">
				<div>
			        <label>Email</label>
			        <?php
			        echo '<input type="email" size="32" name="email" value="' . $_SESSION['email'] . '" required />';
			        echo '<button type="submit" name="emailBoton" value="emailBoton">Guardar</button>';
			        if($errorEmail){ echo '<p class="error">El email ya existe</p>'; }
			        elseif($emailIguales){ echo '<p class="error">No has cambiado el email</p>'; }
			        elseif($_COOKIE['emailCreado']==1)
			        {
			        	echo '<p class="exito">Has modificado el email</p>'; 
			        	setcookie('emailCreado', '0', 0);
			        }
			        ?>
			    </div>
			</form>
			<button><a href="#popup">Cambiar contraseña</a></button>

			<div id="popup" class="overlay">
	            <div id="popupBody">
	                <h2>Cambio de contraseña</h2>
	                <a id="cerrar" href="#">&times;</a>
	                <div class="popupContent">
	                    <form method="post" action="" name="formulario_cambio_contraseña">
							<div>
						        <label>Contraseña actual</label>
						        <input type="password" name="passActual" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Debe contener al menos un número y una letra minúscula y mayúscula, y al menos 8 o más caracteres" required />
						        <br>
						        <?php
						        if($passwordError){ echo '<p class="error">La contraseña es incorrecta</p>'; }
						        ?>
						    </div>
						    <div>
						        <label>Nueva contraseña</label>
						        <input type="password" name="passNueva" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Debe contener al menos un número y una letra minúscula y mayúscula, y al menos 8 o más caracteres" required />
						    </div>
						    <div>
						        <label>Confirmar contraseña</label>
						        <input type="password" name="passConfirmar" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Debe contener al menos un número y una letra minúscula y mayúscula, y al menos 8 o más caracteres" required />
						    </div>
						    <?php
						    if($passwordDistintas){ echo '<p class="error">Las contraseñas no coinciden</p>'; }
						    if($passwordMod) { echo '<p class="exito">La contraseña se ha modificado correctamente</p>'; }
						    ?>
						    <br>
						    <button type="submit" name="cambiar" value="cambiar">Cambiar</button>
						</form>
	                </div>
	            </div>
	        </div>

			<a href="index.php">Volver</a>
		</div>
	</body>
<?php 
	echo "Te has identificado como <b>" . $_SESSION['nombre'] . "</b>";
}
?>
</html>