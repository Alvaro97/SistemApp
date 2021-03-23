<?php
include 'sqlConfig.php';
session_start();
if(!isset($_SESSION['nombre']))
{
  header("Location: index.php");
}
else
{
  if(isset($_POST['añadir']))
  {
    $username = $_POST['username'];
    $grupo = $_POST['grupos'];
    if(strcmp($username, $grupo)!=0)
    {
      $existeUsuario=shell_exec("cat /etc/passwd | awk -F ':' '{print $1}' | grep -w $username");
      if (empty($existeUsuario))
      {
        $errorUsuario=true;
      }
      else
      {
        shell_exec("./añadeUsuarioGrupo.sh $grupo $username");

        $consulta=mysqli_query($conexion,"SELECT * FROM grupos where nombre='$grupo'");
        $fila = mysqli_fetch_array($consulta);
        $gid=$fila['gid'];

        $consulta=mysqli_query($conexion,"SELECT * FROM usuarios where nombre='$username'");
        $fila = mysqli_fetch_array($consulta);
        $uid=$fila['uid'];

        $con="INSERT INTO ug (uid, gid) VALUES ('$uid','$gid')";
        $consulta=mysqli_query($conexion,$con);
        if($consulta)
        {
          $hecho = true;
        }
        else
        {
          echo '<p class="error">Ha ocurrido un fallo.</p>';
        }        
      }
    }
    else
    {
      $errorIguales=true;
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
    <title>SistemApp - Añadir usuarios-grupos</title>
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

    <h1 style="font-size: 50px; text-align: center;">Añadir usuario a grupo</h1>
    <h3 style="text-align: center;">Escribe el nombre del usuario y elige el grupo al que lo quieres añadir.</h3><br>
    <div class="form-element">
      <form method="post" action="" name="formulario_configuracion_nombre">
        <div class="form-element">
          <label>Nombre de usuario</label>
          <input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
          <?php if($errorUsuario){ echo '<p class="error">El usuario insertado no existe</p>'; } ?>
        </div><br>
        <div class="form-element">
          <label>Grupo</label><select name="grupos">
          <?php
          $consulta=mysqli_query($conexion,"SELECT * FROM grupos");
          $nfilas=mysqli_num_rows($consulta);
          if(!empty($consulta) AND $nfilas>0)
          {
            for ($i=0;$i<$nfilas;$i++)
            {
              $fila = mysqli_fetch_array($consulta);
              echo '<option value="' . $fila['nombre'] . '">' . $fila['nombre'] . '</option>';
            }
          }
          else
          {
            echo '<p class="error">ERROR</p>';
          }
          ?>
          </select><br><br><br>
          <button type="submit" name="añadir" value="añadir">Añadir</button><br>
          <?php
          if($errorIguales){ echo '<p class="error">El usuario introducido ya pertenece a ese grupo</p><br>'; }
          if($hecho){ echo '<p class="exito">Se ha añadido a <b>'.$username.'</b> al grupo <b>'.$grupo.'</b></p><br>'; }
          ?>
        </div>
      </form>
    </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

    <?php include 'pie.php'; } ?>
  </body>
</html>