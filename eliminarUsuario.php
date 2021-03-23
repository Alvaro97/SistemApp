<?php
include 'sqlConfig.php';
session_start();

if(!isset($_SESSION['nombre']))
{
	header("Location: index.php");
}
else
{
	if(isset($_POST['borrarUsuario']))
	{
		$usuario = $_POST['username'];
		$existeUsuario = shell_exec("cat /etc/passwd | awk -F ':' '{print $1}' | grep -w $usuario");
		//Si existe el usuario y el usuario no es alvaro(usuario admin)
		if(!empty($existeUsuario) AND strcmp($usuario, 'alvaro') != 0)
		{
			shell_exec("./borrarUsuario.sh $usuario");
			$con = "SELECT * FROM usuarios WHERE nombre='$usuario'";
			$consulta=mysqli_query($conexion,$con);
			$fila= mysqli_fetch_array ($consulta);
			$uid=$fila["uid"];
			$gid=$fila["gid"];
			if(!empty($consulta) AND mysqli_num_rows($consulta)>0)
		    {
		        mysqli_query($conexion,"DELETE from ug where uid='$uid'");
		        mysqli_query($conexion,"DELETE from usuarios where uid='$uid'");
		        mysqli_query($conexion,"DELETE from grupos where gid='$gid'");
		        $borrado = true;
		    }
		    else
		    {
		    	$borrado = true;
		    }
		}
		else
		{
			if(strcmp($usuario, 'alvaro') == 0) { $errorPrincipal = true; }
			else { $errorUsuario = true; }
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
		<title>SistemApp - Eliminar usuario</title>
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
		<link rel="stylesheet" type="text/css" href="css/tabla.css" media="screen" />
	</head>
	<?php include 'cabecera.php'; ?>
	
		<h1 style="font-size: 50px; text-align: center;">Eliminar usuario</h1>
		<h3 style="text-align: center;">Escribe el nombre del usuario que quieres borrar.</h3>
		<div class="form-element">
			<form method="post" action="" name="formulario_configuracion_nombre">
				<div class="form-element">
			        <label>Nombre de usuario</label>
			        <input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
			        <button type="submit" name="borrarUsuario" value="borrarUsuario">Eliminar</button><br>
			        <?php if($errorPrincipal){ echo '<p class="error">alvaro es el usuario principal/administrador y no se puede eliminar.</p>'; }
			        if($errorUsuario){ echo '<p class="error">El usuario no existe</p>'; }
			        if($borrado){ echo '<p class="exito">Usuario '. $usuario .' borrado. Para borrar su directorio escribe en la terminal <b>sudo rm -r /home/'.$usuario.'</b></p>'; }
			        ?>
			    </div>
			</form>
		</div>
     	<?php
        shell_exec("./listarUsuarios.sh");
        echo '<table style="width:90%;"><tr><th>Nombre</th><th>Contraseña</th><th>UID</th>
        <th>GID</th><th>Información</th><th>Directorio de inicio</th><th>Shell</th></tr>';

        //LECTURA DE USUARIOS PERSONALES
        $aux = array();
        if ($file = fopen("usuarios.txt", "r")) {
            while(!feof($file)) {
              echo '<tr class="personal">';
              $i=0;
                $line = fgets($file);
                $aux = explode(":", $line);
                while($i < count($aux))
                {
                  if($i==1){ echo '<td class="x">'.$aux[$i].'</td>'; }
                  else{ echo "<td>$aux[$i]</td>"; }
                  $i++;
                }
                echo '</tr>';
            }
            fclose($file);
        }
        else
        {
          echo '<p class="error">Error de lectura</p>';
        }
        echo '</table>';
        shell_exec("rm usuarios.txt");
        shell_exec("rm usuariosPredefinidos.txt");
        shell_exec("rm usuariosSistema.txt");
   		?>

	<?php include 'pie.php'; } ?>
	</body>
</html>