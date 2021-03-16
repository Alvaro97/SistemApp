<?php
$conexion = mysqli_connect ("localhost", "alvaro", "") or die ("No se puede conectar con el servidor");
mysqli_select_db ($conexion,"sistemapp") or die ("No se puede seleccionar la base de datos");
?>