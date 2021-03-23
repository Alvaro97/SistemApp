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
    <title>SistemApp - Servicios</title>
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

    <h1 style="font-size: 50px; text-align: center;">Listado de servicios</h1><br>
    <h3 style="text-align: center;">Aqui se mostrará el estado de los servicios del sistema.</h3>

      <?php
        echo '<table style="width:80%;"><tr><th>Nombre</th><th>Ruta</th><th>Estado</th></tr>';
        shell_exec("ls -1 /lib/systemd/system > servicios.txt");

        if ($file = fopen("servicios.txt", "r")) {
            while(!feof($file)) {
              echo '<tr class="servicios">';
              $line = fgets($file);
              echo "<td>$line</td>";
              $ruta = shell_exec("./rutaServicio.sh $line");
              $ruta[0] = ' ';
              $ruta[sizeof($ruta)-1] = ' ';
              echo "<td>$ruta</td>";
              $estado = shell_exec("./estadoServicio.sh $line");
              echo "<td>$estado</td>";
              echo '</tr>';
            }
            fclose($file);
        }
        else
        {
          echo '<p class="error">Error de lectura</p>';
        }
        echo '</table>';
        shell_exec("rm servicios.txt");
      ?>

    <?php include 'pie.php'; } ?>
  </body>
</html>