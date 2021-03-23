<?php
include 'sqlConfig.php';
session_start();
if(!isset($_SESSION['nombre']))
{
  header("Location: index.php");
}
else
{
  if(isset($_POST['actualizar']))
  {
    shell_exec("./listarGrupos.sh");
    if ($file = fopen("gruposPersonales.txt", "r")) {
        while(!feof($file)) {
          $line = fgets($file);
          $aux = explode(":", $line);
          $nombre=$aux[0];
          $gid=$aux[1];
          $con="SELECT * FROM grupos WHERE gid='$gid'";
          $consulta=mysqli_query($conexion,$con);
          $fila=mysqli_fetch_array($consulta);
          if(mysqli_num_rows($consulta)<=0)
          {
            $con="INSERT INTO grupos (nombre, gid) VALUES ('$nombre','$gid')";
            $consulta=mysqli_query($conexion,$con);
          }
        }
        $actualizado=true;
        fclose($file);
    }
    else
    {
      echo '<p class="error">Error de lectura</p>';
    }
    shell_exec("rm gruposSistema.txt");
    shell_exec("rm gruposPersonales.txt");
  }

  if(isset($_POST['restablecer']))
  {
    $gid = $_POST['gid'];
    $con="SELECT * FROM grupos WHERE gid='$gid'";
    $consulta=mysqli_query($conexion,$con);
    $fila=mysqli_fetch_array ($consulta);
    if(mysqli_num_rows($consulta)>0)
    {
      $nombre = $fila['nombre'];
      $existe=shell_exec("cat /etc/group | awk -F ':' '{print $1}' | grep -w $nombre");
      
      if (empty($existe))
      {

        $insercionGroup = "echo $nombre:x:$gid: >> /etc/group";
        shell_exec($insercionGroup);

        $restablecido=true;
      }
      else
      {
        $errorEstablecido = true;
      }
    }
    else
    {
      $errorBD = true;
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
    <title>SistemApp - Restablecer usuarios</title>
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
    <link rel="stylesheet" type="text/css" href="css/menu.css" media="screen" />
    <meta property="og:url" content="index.html">
  </head>
  <?php include 'cabecera.php'; ?>

    <h1 style="font-size: 50px; text-align: center;">Restablecer usuarios</h1>
    <h3 style="text-align: center;">Escribe el nombre del usuario que quieres restablecer.<br>
     Para ello se utilizará la copia de seguridad de la base de datos.</h3><br>
    <div class="form-element">
      <form method="post" action="" name="formulario_configuracion_nombre">
        <div class="form-element">
              <label>Pulsa aquí para actualizar la base de datos</label>
              <button type="submit" name="actualizar" value="actualizar">Actualizar</button><br>
              <?php if($actualizado){ echo '<br><p class="exito">Se ha actualizado la copia de seguridad.</p>'; }
              ?>
          </div>
        </form>
        <form method="post" action="" name="formulario_configuracion_nombre">
          <div class="form-element">
              <label>Escribe el GID del grupo que quieres restablecer</label>
              <input type="text" name="gid" pattern="[0-9]+" required />
              <button type="submit" name="restablecer" value="restablecer">Restablecer</button><br>
              <?php if($errorEstablecido){ echo '<br><p class="error">El grupo ya existe en el sistema</p>'; }
              if($errorBD){ echo '<br><p class="error">Error en la base de datos</p>'; }
              if($restablecido){ echo '<br><p class="exito">Grupo '. $nombre .' restablecido.</p>'; }
              ?>
          </div>
      </form>
    </div>

      <?php
        echo '<table style="width:80%;"><tr><th>Nombre</th><th>GID</th>';

        $con = "SELECT * FROM grupos";
        $consulta=mysqli_query($conexion,$con);
        $nfilas= mysqli_num_rows($consulta);
        for ($i=0;$i<$nfilas;$i++)
        {
          $fila=mysqli_fetch_array ($consulta);
          echo '<tr><td>'.$fila["nombre"].'</td><td>'.$fila["gid"].'</td></tr>';
        }
        echo '</table><br>';
      ?>

    <?php include 'pie.php'; } ?>
  </body>
</html>