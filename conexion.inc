<?php

//header('Content-Type: text/html; charset=UTF-8'); 

if(!function_exists('register_globals')){
	include('register_globals.php');
	register_globals();
}else{
}

$conexion=mysql_connect("localhost","minkauserbd","4868422Marco$");
$bd=mysql_select_db("tuadmingatito");
?>
