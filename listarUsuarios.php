<?php
session_start();
if(!isset($_SESSION['nombre']))
{
  header("Location: index.php");
}
else
{
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
    <title>SistemApp - Listado usuarios</title>
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
    <link rel="stylesheet" type="text/css" href="css/tabla.css" media="screen" />
    <meta property="og:url" content="index.html">
  </head>
  <?php include 'cabecera.php'; ?>

    <h1 style="font-size: 50px; text-align: center;">Listado de usuarios del sistema</h1><br>

    <div class="colores">
      <b class="color1">Usuarios predefinidos (UID entre 0 y 99)</b><br>
		  <b class="color2">Usuarios del sistema (UID entre 100 y 999)</b><br>
		  <b class="color3">Usuarios personales (UID mayor a 1000)</b><br>
    </div>

      <?php
        shell_exec("./listarUsuarios.sh");
        echo '<table style="width:90%;"><tr><th>Nombre</th><th>Contraseña</th><th>UID</th>
        <th>GID</th><th>Información</th><th>Directorio de inicio</th><th>Shell</th></tr>';

        //LECTURA DE USUARIOS PREDEFINIDOS
        $aux = array();
        if ($file = fopen("usuariosPredefinidos.txt", "r")) {
            while(!feof($file)) {
              echo '<tr class="predefinido">';
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

        //LECTURA DE USUARIOS DE ADMINISTRACION DEL SISTEMA
        $aux = array();
        if ($file = fopen("usuariosSistema.txt", "r")) {
            while(!feof($file)) {
              echo '<tr class="sistema">';
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

  	<div class="colores">
		<form method="post" action="descargartxt.php">
  			<p>Descargar fichero .txt con todos los usuarios</p>
  			<button name="usuarios" value="usuarios">Descargar</button>
		</form><br>
    </div>

    <?php include 'pie.php'; } ?>
  </body>
</html>