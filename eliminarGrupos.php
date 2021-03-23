<?php
include 'sqlConfig.php';
session_start();
if(!isset($_SESSION['nombre']))
{
  header("Location: index.php");
}
else
{
  if(isset($_POST['borrarGrupo']))
  {
    $grupo = $_POST['nombre'];
    $existeGrupo = shell_exec("cat /etc/group | awk -F ':' '{print $1}' | grep -w $grupo");
    if(!empty($existeGrupo) AND strcmp($grupo, 'alvaro') != 0)
    {
      shell_exec("./borrarGrupo.sh $grupo");
      $con = "SELECT * FROM grupos WHERE nombre='$grupo'";
      $consulta=mysqli_query($conexion,$con);
      $fila = mysqli_fetch_array($consulta);
      $gid=$fila['gid'];
      if(!empty($consulta) AND mysqli_num_rows($consulta)>0)
      {
        $con = "SELECT * FROM ug WHERE gid='$gid'";
        $consulta=mysqli_query($conexion,$con);
        if(!empty($consulta) AND mysqli_num_rows($consulta)>0)
        {
          mysqli_query($conexion,"DELETE from ug where gid='$gid'");
        }
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
      if(strcmp($grupo, 'alvaro') == 0) { $errorPrincipal = true; }
      else { $errorGrupo = true; }
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
    <title>SistemApp - Borrar grupos</title>
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

    <h1 style="font-size: 50px; text-align: center;">Borrar grupos</h1><br>
    <h3 style="text-align: center;">Escribe el nombre del grupo que quieres borrar.</h3>
    <div class="form-element">
      <form method="post" action="" name="formulario_configuracion_nombre">
        <div class="form-element">
              <label>GID</label>
              <input type="text" name="nombre" pattern="[a-zA-Z0-9]+" required />
              <button type="submit" name="borrarGrupo" value="borrarGrupo">Eliminar</button><br>
              <?php if($errorPrincipal){ echo '<p class="error">alvaro es el grupo principal/administrador y no se puede eliminar.</p>'; }
              if($errorGrupo){ echo '<p class="error">El grupo no existe</p>'; }
              if($borrado){ echo '<p class="exito">Grupo '. $grupo .' borrado</p>'; }
              ?>
          </div>
      </form>
    </div>

      <?php
        shell_exec("./listarGrupos.sh");
        echo '<table style="width:90%;"><tr><th>Nombre</th><th>GID</th><th>Miembros</th></tr>';

        //LECTURA DE GRUPOS PERSONALES
        $aux = array();
        if ($file = fopen("gruposPersonales.txt", "r")) {
            while(!feof($file)) {
              echo '<tr class="personal">';
              $i=0;
                $line = fgets($file);
                $aux = explode(":", $line);
                while($i < count($aux))
                {
                  if($i==2)
                  {
                    $res="";
                    $j=0;
                    $miembros=shell_exec("./miembrosGrupo.sh $aux[1]");
                    $auxMiembros=explode(";", $miembros);
                    if(empty($auxMiembros[0])){ $res=$aux[2]; }
                    else
                    {
                      $res=$aux[2];
                      for ($j=0; $j < count($auxMiembros); $j++) { 
                        $res=$res.','.trim($auxMiembros[$j]);
                      }
                    }
                    if($res[0]==','){ $res[0]=' '; }
                    if($res[1]==','){ $res[1]=' '; }
                    if($res[sizeof($res)]==','){ $res[sizeof($res)]=' '; }
                    if($res[sizeof($res)-1]==','){ $res[sizeof($res)-1]=' '; }
                    echo "<td>$res</td>";
                  }
                  else
                  {
                    echo "<td>$aux[$i]</td>";
                  }
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
        shell_exec("rm gruposSistema.txt");
        shell_exec("rm gruposPersonales.txt");
      ?>

    <?php include 'pie.php'; } ?>
  </body>
</html>