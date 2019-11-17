<?php
include("conexion.php");
session_start();
date_default_timezone_set('America/Asuncion');
error_reporting(0);

$usuarioactivo=$_SESSION["usuarioactivo"];
$bloqueoempleado=$_SESSION["bloqueoempleado"];
$codigo=$_SESSION["codigo_cliente"];

if ($bloqueoempleado==1) {header("Location:administracion/");}

if($usuarioactivo==1 and $bloqueoempleado!=1){
	require 'menu.ctp';
	function entregas($estado,$codigo,$titulo='',$color='',$extra,$momento){
		include("conexion.php");

		if ($momento==1 and $extra==1) {
			$busqueda="SELECT * FROM empleado,factura,cliente where cliente.cli_codigo=factura.cli_codigo 
			and empleado.emp_codigo=factura.emp_codigo and factura.est_codigo=$estado 
			and fac_fecha like '%$codigo%'";

		}elseif ($momento==1 and $extra!=1) {
			$busqueda="SELECT * FROM factura,cliente 
			where cliente.cli_codigo=factura.cli_codigo 
			and factura.est_codigo=$estado 
			and fac_fecha like '%$codigo%'";
		
		}elseif ($extra==1) {
			$busqueda="SELECT * FROM empleado,factura,cliente where cliente.cli_codigo=factura.cli_codigo 
			and empleado.emp_codigo=factura.emp_codigo and factura.est_codigo=$estado 
			and cliente.cli_codigo=$codigo";
		
		}else{
			$busqueda="SELECT * FROM factura,cliente 
			where cliente.cli_codigo=factura.cli_codigo 
			and factura.est_codigo=$estado 
			and cliente.cli_codigo=$codigo";
		}
		
		$res = mysqli_query($conexion, $busqueda);
		echo "<h1 style='color:$color;'>$titulo</h1><br>
		<table >";
		while ($row = mysqli_fetch_array($res)){
			$nombre=$row["cli_nombre"];
			$apellido=$row["cli_apellido"];
			$nombrecompleto="$nombre $apellido";
			$fecha=$row["fac_fecha"];//preguntar
			$nro=$row["fac_codigo"];
			$direcion=$row["cli_direccion"];
			$obs=$row["fac_obs"];
			if ($extra==1) {
				$nom_emp=$row["emp_nombre"];
				$ape_emp=$row["emp_apellido"];
			}
			
			echo "
			<tr><td>Medicamento</td><td>Cantidad</td></tr>
			<tr><td colspan='5'><hr width='100%'/></td></tr>";
			$busqueda_detalle="SELECT * FROM factura,factura_detalle,producto where factura.fac_codigo=factura_detalle.fac_codigo
			and factura_detalle.pro_codigo=producto.pro_codigo
			and factura.fac_codigo=$nro";
			
			$res2 = mysqli_query($conexion, $busqueda_detalle);
			while ($row2 = mysqli_fetch_array($res2)){
				$producto_nombre=$row2["pro_descripcion"];
				$cantidad=$row2["fac_det_cantidad"];
				echo "<tr><td>$producto_nombre</td><td>$cantidad</td></tr>";
			}
			if ($extra==1) {
				echo "<tr><td colspan='5'>No se entrego por:$obs</td></tr>
				";
			}
			echo "
			<tr><td colspan='5'>
			<hr width='100%'/></td></tr>";
		}
		echo "</table>";
	}
	entregas(1,$codigo,'Compras ya Entregadas','green',0,0);
	entregas(2,$codigo,'Compras Canceladas','red',1,0);
	entregas(3,$codigo,'Compras Aun sin Revisar','yellow',0,0);
	entregas(4,$codigo,'Compras en Proceso de entrega','orange',0,0);
}