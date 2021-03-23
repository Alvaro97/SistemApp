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
					$_SESSION['passwordMod'] = 1;
					header("Location: panelControl.php");
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
<!DOCTYPE html>
<html style="font-size: 16px;">
	<head>
	  	<meta http-equiv="Expires" content="0">
		<meta http-equiv="Last-Modified" content="0">
		<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
		<meta http-equiv="Pragma" content="no-cache">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta charset="utf-8">
	    <meta name="page_type" content="np-template-header-footer-from-plugin">
	    <title>SistemApp - Cambio Contraseña</title>
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
	    <link rel="stylesheet" type="text/css" href="css/errores.css" media="screen" />
	    <link rel="stylesheet" type="text/css" href="css/menu.css" media="screen" />
	    <meta property="og:url" content="index.html">
  	</head>
  	<?php include 'cabecera.php'; ?>
  		<h1 style="font-size: 50px; text-align: center;">Panel de Control</h1>
		<h3 style="text-align: center;">Cambio de contraseña</h3>
		<div class="form-element">
			<form method="post" action="" name="formulario_cambio_contraseña">
				<div>
			        <label>Contraseña actual&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			        <input type="password" name="passActual" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Debe contener al menos un número y una letra minúscula y mayúscula, y al menos 8 o más caracteres" required />
			        <br>
			        <?php
			        if($passwordError){ echo '<p class="error">La contraseña es incorrecta</p>'; }
			        ?>
			    </div>
			    <div>
			        <label>Nueva contraseña&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			        <input type="password" name="passNueva" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Debe contener al menos un número y una letra minúscula y mayúscula, y al menos 8 o más caracteres" required />
			    </div>
			    <div>
			        <label>Confirmar contraseña&nbsp;&nbsp;&nbsp;</label>
			        <input type="password" name="passConfirmar" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Debe contener al menos un número y una letra minúscula y mayúscula, y al menos 8 o más caracteres" required />
			    </div>
			    <?php
			    if($passwordDistintas){ echo '<p class="error">Las contraseñas no coinciden</p>'; }
			    if($passwordMod) { echo '<p class="exito">La contraseña se ha modificado correctamente</p>'; }
			    ?>
			    <br>
			    <button type="submit" name="cambiar" value="cambiar">Cambiar</button>
			    <a href="panelControl.php">Volver</a>
			</form>
		</div>
  	<?php include 'pie.php'; } ?>
</body>
</html>