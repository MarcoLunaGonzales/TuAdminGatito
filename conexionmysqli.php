<?php
header('Content-Type: text/html; charset=UTF-8'); 
date_default_timezone_set('America/La_Paz');

if(!function_exists('register_globals')){
	include('register_globals.php');
	register_globals();
}else{
}

$enlaceCon=mysqli_connect("localhost","minkauserbd","4868422Marco$","tuadmingatito");

if (mysqli_connect_errno())
{
	echo "Error en la conexion: " . mysqli_connect_error();
}
mysqli_set_charset($enlaceCon,"utf8");
?>