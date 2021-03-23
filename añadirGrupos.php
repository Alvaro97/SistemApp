<?php
include 'sqlConfig.php';
session_start();

if(!isset($_SESSION['nombre']))
{
	header("Location: index.php");
}
else
{
	if(isset($_POST['añadirGrupo']))
	{
		$nombre = $_POST['nombre'];
		$gid = $_POST['gid'];
		$existeGrupo=shell_exec("cat /etc/group | awk -F ':' '{print $1}' | grep -w $nombre");
		$existeGID=shell_exec("cat /etc/group | awk -F ':' '{print $3}' | grep -w $gid");
		if (empty($existeGID) AND empty($existeGrupo)) 
		{
			$insercionGroup = "echo $nombre:x:$gid: >> /etc/group";
			shell_exec($insercionGroup);
			$con = "SELECT * FROM grupos WHERE gid=$gid";
			$consulta=mysqli_query($conexion,$con);
			if(!empty($consulta) AND mysqli_num_rows($consulta)>0)
		    {
		        $errorGID = true;
		    }
		    else
		    {
		    	$con="INSERT INTO grupos (nombre, gid) VALUES ('$nombre','$gid')";
				$consulta=mysqli_query($conexion,$con);
			    if($consulta)
				{
					$insertado = true;
				}
				else
				{
					echo '<p class="error">Ha ocurrido un fallo.</p>';
				}
		    }

		}
		else
		{
			if(!empty($existeGID)){ $errorGID=true; }
			if(!empty($existeGrupo)){ $errorGrupo=true; }
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
		<title>SistemApp - Añadir grupo</title>
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
	
		<h1 style="font-size: 50px; text-align: center;">Añadir grupo</h1>
		<h3 style="text-align: center;">Rellena los siguientes campos.</h3>
		<div class="form-element">
			<form method="post" action="" name="formulario_configuracion_nombre">
				<div class="form-element">
			        <label>Nombre de usuario</label>
			        <input type="text" name="nombre" pattern="[a-zA-Z0-9]+" required />
			        <?php if($errorGrupo){ echo '<br><p class="error">Ya existe un grupo con ese nombre</p>'; } ?>
			    </div>
			    <div class="form-element">
			        <label>GID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			        <input type="text" name="gid" pattern="[0-9]+" required />
			        <?php if($errorGID){ echo '<br><p class="error">Ya existe un grupo con ese GID</p>'; } ?>
			    </div>
			    <button type="submit" name="añadirGrupo" value="añadirGrupo">Añadir</button><br>
			    <?php if($insertado){ echo '<p class="exito">Grupo creado</p>'; } ?>
			</form>
		</div>

	<?php include 'pie.php'; } ?>
	</body>
</html>