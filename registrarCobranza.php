<html>
    <head>
        <title>Busqueda</title>
        <script type="text/javascript" src="lib/externos/jquery/jquery-1.4.4.min.js"></script>
        <script type="text/javascript" src="dlcalendar.js"></script>
        <script type='text/javascript' language='javascript'>
function nuevoAjax()
{	var xmlhttp=false;
	try {
			xmlhttp = new ActiveXObject('Msxml2.XMLHTTP');
	} catch (e) {
	try {
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	} catch (E) {
		xmlhttp = false;
	}
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
 	xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}
function ajaxCargarDeudas(){
	var contenedor;
	contenedor = document.getElementById('divDetalle');

	var codCliente = document.getElementById('cliente').value;

	ajax=nuevoAjax();

	ajax.open("GET", "ajaxCargarDeudas.php?codCliente="+codCliente,true);

	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			contenedor.innerHTML = ajax.responseText;
		}else{
			contenedor.innerHTML = "Cargando...";
		}
	}
	ajax.send(null)
}

function totales(){
	var subtotal=0;
	var totalRegistros=document.getElementById("totalRegistros").value;
	for(var ii=1;ii<=totalRegistros;ii++){
	 	if(document.getElementById('montoPago'+ii)!=null){
			var monto=document.getElementById("montoPago"+ii).value;
			subtotal=subtotal+parseFloat(monto);
		}
    }
	subtotal=redondear(subtotal,2);
    document.getElementById("totalCobro").value=subtotal;
}


function validar(f){   
	var codCliente=document.getElementById("cliente").value;
	var numRegistros=document.getElementById("totalRegistros").value;
	var monto;
	var nroDoc;
	console.log(numRegistros);
	
	if(numRegistros>0){
		var subtotal=0;
		for(var i=1; i<=numRegistros; i++){
			monto=parseFloat(document.getElementById("montoPago"+i).value);
			subtotal+=monto;
			nroDoc=parseFloat(document.getElementById("nroDoc"+i).value);
		}
		if(subtotal<=0){
				alert("El monto Total cobrado debe ser mayor a 0");
				return false;
		}
		return (true);
	}else{
		alert("Debe existir al menos 1 registro.");
		return false;
	}
}

function solonumeros(e)
{
	var key;
	if(window.event) {// IE
		key = e.keyCode;
	}else if(e.which) // Netscape/Firefox/Opera
	{
		key = e.which;
	}
	if (key < 46 || key > 57) 
	{
	  return false;
	}
	return true;
}

function redondear(value, precision) {
    var multiplier = Math.pow(10, precision || 0);
    return Math.round(value * multiplier) / multiplier;
}
	

	</script>
<?php

require("conexion.inc");
require("estilos_almacenes.inc");

$globalCiudad=$_COOKIE["global_agencia"];

?>
<body>
<form action='guardarCobranza.php' method='post' name='form1'>
<h3 align="center">Registrar Cobranzas</h3>

<table border='0' class='texto' cellspacing='0' align='center' width='80%' style='border:#ccc 1px solid;'>
<tr><th>Cliente</th><th>Fecha Pago</th><th>Observaciones</th></tr>
<?php
$sql1="select cod_cliente, nombre_cliente from clientes where cod_area_empresa=$globalCiudad order by 2";
$resp1=mysql_query($sql1);
?>
<tr>
<td align='center'>
<select name='cliente' id='cliente' class='texto' onChange="ajaxCargarDeudas();">
	<option value="0">Seleccione una opcion</option>
<?php
while($dat1=mysql_fetch_array($resp1))
{   $codigo=$dat1[0];
    $nombre=$dat1[1];
?>
	<option value="<?php echo $codigo; ?>"><?php echo $nombre; ?></option>
<?php	
}
$fecha=date("d/m/Y");
?>
</select>
</td>
<td>
<input type='text' class='texto' value='<?php echo $fecha; ?>' id='fecha' size='10' name='fecha'>
<img id='imagenFecha' src='imagenes/fecha.bmp'>
</td>
<td>
<input type='text' class='texto' value="" id='observaciones' size='40' name='observaciones'>
</td>


</tr>
</table>

</br>

<div id="divDetalle">
	<table border='0' class='texto' cellspacing='0' align='center' width='90%' style='border:#ccc 1px solid;'>
		<tr><th>Nro. OC</th><th>Fecha OC</th><th>Monto OC</th><th>A Cuenta</th><th>Saldo OC</th><th>Monto a Pagar</th><th>Nro. Doc. Pago</th></tr>
		<input type="hidden" name="totalRegistros" id="totalRegistros" value="0">
	</table>
</div>


<div class='divBotones'>
	<input type='submit' class='boton' value='Guardar' onClick='return validar(this.form)'>
	<input type='button' class='boton2' value='Cancelar' onClick="location.href='navegador_pagos.php'";></div>
</div>

<script type='text/javascript' language='javascript'  src='dlcalendar.js'></script>

</form>
</body>