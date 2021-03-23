<?php
include 'sqlConfig.php';
session_start();

if(!isset($_SESSION['nombre']))
{
	header("Location: index.php");
}
else
{
	if(isset($_POST['añadirUsuario']))
	{
		$usuario = $_POST['username'];
		$uid = $_POST['uid'];
		$gid = $_POST['gid'];
		$info = $_POST['info'];
		$homedir = $_POST['homedir'];
		$shell = $_POST['shell'];
		$existe=shell_exec("cat /etc/passwd | grep -w $usuario");
		if(empty($homedir)){ $homedir='/home/' . $usuario; }
		if(empty($shell)){ $shell='/bin/bash'; }
		if (empty($existe)) {
			$existeUID=shell_exec("cat /etc/passwd | awk -F ':' '{print $3}' | grep -w $uid");
			if (empty($existeUID)) 
			{
				$existeGID=shell_exec("cat /etc/group | awk -F ':' '{print $3}' | grep -w $uid");
				if(empty($existeGID))
				{
					$hashed='$6$Puwqsg2cAEgdJ0jE$meNqxVSwUUZW/n6X/MJWao1JCEkAFK1XC00QSGTpf5aPeqKeSXK.ka98ITYBFwARBMRCs1fN34UCjS0quFu3l.';
					$insercionPasswd = "echo $usuario:x:$uid:$gid:$info:$homedir:$shell >> /etc/passwd";
					$insercionShadow = "echo $usuario:" . $hashed . ":18707:0:99999:7::: >> /etc/shadow";
					$insercionGroup = "echo $usuario:x:$gid: >> /etc/group";
					shell_exec($insercionPasswd);
					shell_exec($insercionShadow);
					shell_exec($insercionGroup);
					shell_exec("mkdir $homedir");
					shell_exec("cp /etc/skel/.bash_logout $homedir");
					shell_exec("cp /etc/skel/.profile $homedir");
					shell_exec("cp /etc/skel/.bashrc $homedir");
					shell_exec("chown $usuario $homedir");
				
					$con = "SELECT * FROM usuarios WHERE uid=$uid";
					$consulta=mysqli_query($conexion,$con);
					if(!empty($consulta) AND mysqli_num_rows($consulta)>0)
				    {
				        $errorUsuario = true;
				    }
					else
					{
						
						$con = "SELECT * FROM grupos WHERE gid=$gid";
						$consulta=mysqli_query($conexion,$con);
						
						if(!empty($consulta) AND mysqli_num_rows($consulta)>0)
					    {
					        $errorGID = true;
					    }
					    else
					    {
					    	$con="INSERT INTO usuarios (nombre, uid, gid, informacion, homedirectory, interprete) VALUES ('$usuario','$uid','$gid','$info','$homedir','$shell')";
							$consulta=mysqli_query($conexion,$con);
							
							if($consulta)
							{
								$con="INSERT INTO grupos (nombre, gid) VALUES ('$usuario','$gid')";
								$consulta=mysqli_query($conexion,$con);
								if($consulta)
								{
									$con="INSERT INTO ug (uid, gid) VALUES ('$uid','$gid')";
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
								else
								{
									echo '<p class="error">Ha ocurrido un fallo.</p>';
								}
							}
							else
							{
								echo '<p class="error">Ha ocurrido un fallo.</p>';
							}
						}
					}

				}
				else
				{
					$errorGID = true;
				}
			}
			else
			{
				$errorUID = true;
			}
		}
		else
		{
			$errorUsuario = true;
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
		<title>SistemApp - Añadir usuario</title>
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
	
		<h1 style="font-size: 50px; text-align: center;">Añadir usuario</h1>
		<h3 style="text-align: center;">Rellena los siguientes campos. (*=Obligatorio rellenar)</h3>
		<div class="form-element">
			<form method="post" action="" name="formulario_configuracion_nombre">
				<div class="form-element">
			        <label>Nombre de usuario *</label>
			        <input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
			        <?php if($errorUsuario){ echo '<p class="error">El usuario existe</p>'; } ?>
			    </div>
			    <div class="form-element">
			        <label>UID *&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			        <input type="number" name="uid" required />
			        <?php if($errorUID){ echo '<br><p class="error">Ya existe un usuario con ese UID</p>'; } ?>
			    </div>
			    <div class="form-element">
			        <label>GID *&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			        <input type="number" name="gid" required />
			        <?php if($errorUID){ echo '<br><p class="error">Ya existe un grupo con ese GID</p>'; } ?>
			    </div>
			    <div class="form-element">
			        <label>Información&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			        <input type="text" name="info" />
			    </div>
			    <div class="form-element">
			        <label>Directorio personal&nbsp;&nbsp;&nbsp;</label>
			        <input type="text" name="homedir" />
			    </div>
			    <div class="form-element">
			        <label>Shell&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			        <input type="text" name="shell" />
			    </div>
			    <button type="submit" name="añadirUsuario" value="añadirUsuario">Añadir</button><br>
			    <?php if($insertado){ echo '<p class="exito">Usuario creado. Escribe en la terminal <b>sudo passwd ' . $usuario . '</b> para establecer la contraseña al usuario</p>'; } ?>
			</form>
		</div>

	<?php include 'pie.php'; } ?>
	</body>
</html>