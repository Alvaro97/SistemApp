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

?>

<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="Expires" content="0">
		<meta http-equiv="Last-Modified" content="0">
		<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
		<meta http-equiv="Pragma" content="no-cache">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta charset="utf-8">
	    <meta name="page_type" content="np-template-header-footer-from-plugin">
		<title>SistemApp - Panel de Control</title>
		<link rel="stylesheet" href="nicepage.css" media="screen">
	    <link rel="stylesheet" href="Sistemapp.css" media="screen">
	    <script class="u-script" type="text/javascript" src="js/jquery.js" defer=""></script>
	    <script class="u-script" type="text/javascript" src="js/nicepage.js" defer=""></script>
	    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i">
	    
	    <script type="application/ld+json">{
			"@context": "http://schema.org",
			"@type": "Organization",
			"name": "",
			"url": "index.html",
			"logo": "images/Captura.PNG"
	    }</script>
	    <meta property="og:title" content="Sistemapp">
	    <meta property="og:type" content="website">
	    <meta name="theme-color" content="#b9dfdf">
	    <link rel="canonical" href="index.html">
	    <meta property="og:url" content="index.html">
		<link rel="stylesheet" type="text/css" href="css/errores.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="css/menu.css" media="screen" />
	</head>
	<?php include 'cabecera.php'; ?>
		<h1 style="font-size: 50px; text-align: center;">Panel de Control</h1>
		<h3 style="text-align: center; text-decoration: underline;">Datos del usuario administrador de Sistemapp</h3><br>
		<div class="form-element">
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
			        <label>Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			        <?php
			        echo '<input type="email" name="email" value="' . $_SESSION['email'] . '" required />';
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
			<button><a href="cambioPassword.php">Cambiar contraseña</a></button><br>
			<?php if($_SESSION['passwordMod']==1){ echo '<p class="exito">Se ha modificado la contraseña</p>'; $_SESSION['passwordMod']=0;  } ?>
		</div>
		<br>
		<h3 style="text-align: center; text-decoration: underline;">Información del sistema</h3>

		<div class="form-element">
			<label>Sistema operativo:&nbsp;</label>
			<?php 
			$so = shell_exec("lsb_release -a | grep -w Distributor | awk '{print $3}'");
			echo $so;
			?>
		</div>
		<div class="form-element">
			<label>Versión del sistema:&nbsp;</label>
			<?php 
			$vers = shell_exec("lsb_release -a | grep -w Release | awk '{print $2}'");
			echo $vers;
			?>
		</div>
		<div class="form-element">
			<label>Dirección puerta de enlace:&nbsp;</label>
			<?php 
			$gateway = shell_exec("cat /etc/netplan/01-network-manager-all.yaml | grep -w gateway4 | awk '{print $2}'");
			echo $gateway;
			?>
		</div>
		<div class="form-element">
			<label>Dirección IP:&nbsp;</label>
			<?php 
			$ip = shell_exec("ifconfig | grep broadcast -w | awk '{print $2}'");
			echo $ip;
			?>
		</div>
		<div class="form-element">
			<label>Fecha actual:&nbsp;</label>
			<?php 
			$date = shell_exec("date");
			echo $date;
			?>
		</div>
		<br>

		<h3 style="text-align: center; text-decoration: underline;">Borrado copia de seguridad</h3>

		<div class="form-element">
			<label>Pulsa el botón si quieres borrar la copia de seguridad&nbsp;</label>
			<button><a href="confirmar.php">Borrar</a></button><br>
			<?php if($_SESSION['borrado']==1){ echo '<p class="exito">Se ha borrado la copia.</p>'; $_SESSION['borrado']=0; } ?>
		</div>
		<br><br>
	<?php include 'pie.php'; } ?>
	</body>
</html>