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
    shell_exec("./listarUsuarios.sh");
    if ($file = fopen("usuarios.txt", "r")) {
        while(!feof($file)) {
          $line = fgets($file);
          $aux = explode(":", $line);
          $nombre=$aux[0];
          $uid=$aux[2];
          $gid=$aux[3];
          $info=$aux[4];
          $directorio=$aux[5];
          $interprete=$aux[6];
          $con="SELECT * FROM usuarios WHERE nombre='$nombre'";
          $consulta=mysqli_query($conexion,$con);
          $fila=mysqli_fetch_array ($consulta);
          if(mysqli_num_rows($consulta)<=0)
          {
            $con="INSERT INTO usuarios (nombre, uid, gid, informacion, homedirectory, interprete) VALUES ('$nombre','$uid','$gid','$info','$directorio','$interprete')";
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
    shell_exec("rm usuarios.txt");
    shell_exec("rm usuariosPredefinidos.txt");
    shell_exec("rm usuariosSistema.txt");
  }

  if(isset($_POST['restablecer']))
  {
    $usuario = $_POST['username'];
    $con="SELECT * FROM usuarios WHERE nombre='$usuario'";
    $consulta=mysqli_query($conexion,$con);
    $fila=mysqli_fetch_array ($consulta);
    if(mysqli_num_rows($consulta)>0)
    {
      $uid = $fila['uid'];
      $gid = $fila['gid'];
      $info = $fila['informacion'];
      $homedir = $fila['homedirectory'];
      $shell = $fila['interprete'];
      $existe=shell_exec("cat /etc/passwd | awk -F ':' '{print $1}' | grep -w $usuario");
      
      if (empty($existe))
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
              <label>Escribe el nombre del usuario que quieres restablecer.</label>
              <input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
              <button type="submit" name="restablecer" value="restablecer">Restablecer</button><br>
              <?php if($errorEstablecido){ echo '<br><p class="error">El usuario ya existe en el sistema</p>'; }
              if($errorBD){ echo '<br><p class="error">Error en la base de datos</p>'; }
              if($restablecido){ echo '<br><p class="exito">Usuario '. $usuario .' restablecido. Escribe en la terminal <b>sudo passwd ' . $usuario . '</b> para establecerle la contraseña.</p>'; }
              ?>
          </div>
      </form>
    </div>

      <?php
        echo '<table style="width:90%;"><tr><th>Nombre</th><th>Contraseña</th><th>UID</th>
        <th>GID</th><th>Información</th><th>Directorio de inicio</th><th>Shell</th></tr>';

        $con = "SELECT * FROM usuarios";
        $consulta=mysqli_query($conexion,$con);
        $nfilas= mysqli_num_rows($consulta);
        for ($i=0;$i<$nfilas;$i++)
        {
          $fila=mysqli_fetch_array ($consulta);
          echo '<tr><td>'.$fila["nombre"].'</td><td class="x">x</td><td>'.$fila["uid"].'</td><td>'.$fila["gid"].'</td><td>'.$fila["informacion"].'</td><td>'.$fila["homedirectory"].'</td><td>'.$fila["interprete"].'</td></tr>';
        }
        echo '</table><br>';
      ?>

    <?php include 'pie.php'; } ?>
  </body>
</html>