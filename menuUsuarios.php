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
    <title>SistemApp - Usuarios</title>
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

    <br><br><h1 style="font-size: 50px; text-align: center;">Menú usuarios</h1><br>

    <div class="form-element">
		<button class="b"><a href="listarUsuarios.php">Listado</a></button>
		<button class="b"><a href="añadirUsuario.php">Añadir</a></button>
		<button class="b"><a href="eliminarUsuario.php">Eliminar</a></button>
		<button class="b"><a href="restablecerUsuario.php">Restablecer</a></button>
		<br>
	</div>
	<br><br><br>
<?php include 'pie.php'; } ?>



    
  </body>
</html>