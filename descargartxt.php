<?php
  if(isset($_POST['usuarios']))
  {
    $file = "usuarios.txt";
	$txt = fopen($file, "w") or die("Ha ocurrido un error");
	$contenido=shell_exec("cat /etc/passwd");
	fwrite($txt, $contenido);
	fclose($txt);

	header('Content-Description: File Transfer');
	header('Content-Disposition: attachment; filename='.basename($file));
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize($file));
	header("Content-Type: text/plain");
	readfile($file);
  }
  if(isset($_POST['grupos']))
  {
    $file = "grupos.txt";
	$txt = fopen($file, "w") or die("Ha ocurrido un error");
	$contenido=shell_exec("cat /etc/groups");
	fwrite($txt, $contenido);
	fclose($txt);

	header('Content-Description: File Transfer');
	header('Content-Disposition: attachment; filename='.basename($file));
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize($file));
	header("Content-Type: text/plain");
	readfile($file);
  }
?>