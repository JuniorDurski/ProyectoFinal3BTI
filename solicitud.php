<?php

include("conexion.php");
session_start();
date_default_timezone_set('America/Asuncion');
error_reporting(0);

$usuarioactivo=$_SESSION["usuarioactivo"];
$bloqueoempleado=$_SESSION["bloqueoempleado"];
$codigocliente=$_SESSION["codigo_cliente"];

if ($bloqueoempleado==1) {header("Location:administracion/");}

if($usuarioactivo==1 and $bloqueoempleado!=1){
	$codigosolicitud=$_SESSION["codigosolicitud"];
	require 'menu.ctp';

	if (!empty($_POST["nuevo"])) {
		$agregar_solicitud="INSERT INTO solicitud(cli_codigo,est_codigo,sol_total) values($codigocliente,1,0)";
		mysqli_query($conexion,$agregar_solicitud);
	}
	
	if (!empty($_POST["agregar"])) {
		
		$pre=$_POST["precio"];
		$cod_pro=$_POST["codigo_pro"];
		$cant=$_POST["cantidad"];
		$cantidad_original=$_POST["cantidad_original"];

		if ($cant>0) {
			$sub_total=$pre*$cant;
			$resta=$cantidad_original-$cant;

			$agregar_detalle="INSERT INTO solicitud_detalle(sol_det_codigo, sol_det_cantidad,sol_codigo, pro_codigo, sol_det_subtotal) 
			VALUES (NULL,'$cant','$codigosolicitud','$cod_pro','$sub_total')";
			mysqli_query($conexion,$agregar_detalle);

			$menosproducto="UPDATE producto set pro_cantidad=$resta where pro_codigo=$cod_pro";
			mysqli_query($conexion,$menosproducto);

		}
	}

	if (!empty($_POST["eliminar"])) {
		
		$cod_eli=$_POST["codigoeliminar"];
		$cod_pro=$_POST["codigoproducto"];
		$cant=$_POST["cantidad"];
		$cantidad_original=$_POST["cantidad_original"];
		$suma=$cantidad_original+$cant;

		$eliminar="DELETE FROM solicitud_detalle WHERE solicitud_detalle.sol_det_codigo=$cod_eli";
		mysqli_query($conexion,$eliminar);
		
		$masproducto="UPDATE producto set pro_cantidad=$suma where pro_codigo=$cod_pro";
		mysqli_query($conexion,$masproducto);

	}

	if (!empty($_POST["finalizar"])) {
		
		$fecha=date("Y-m-d H:i:s");
		$total=0;
		
		$subtotal="SELECT * FROM solicitud,solicitud_detalle WHERE solicitud_detalle.sol_codigo=solicitud.sol_codigo
		and cli_codigo=$codigocliente and est_codigo=1";
		$res = mysqli_query($conexion, $subtotal);

		while ($row = mysqli_fetch_array($res)) {
			$nro=$row["sol_det_subtotal"];
			$total=$total+$nro;
		}
		
		if ($total>0) {
			$finalizar_solicitud="UPDATE solicitud set est_codigo=2,sol_instante_pedido='$fecha',sol_total='$total' 
			where sol_codigo=$codigosolicitud";
			mysqli_query($conexion,$finalizar_solicitud);
		}	
		
		$_SESSION["factura"]=1;
		header("Location:factura.php");
	
	}

	$query="SELECT * from solicitud where cli_codigo=$codigocliente ORDER BY sol_codigo DESC limit 1";
	$res = mysqli_query($conexion, $query);
	
	while ($row = mysqli_fetch_array($res)) {
		$estado=$row["est_codigo"];
		$cod=$row["sol_codigo"];
		$_SESSION["codigosolicitud"]=$cod;
	}

	if ($estado==1) {
		echo "<br>Agregar Medicameto<br><br>
		<table>";
		
		$buscar="SELECT * from producto where pro_cantidad>0";
		$res = mysqli_query($conexion, $buscar);
			
		while ($row = mysqli_fetch_array($res)) {
			$codigo_producto=$row["pro_codigo"];
			$nombre=$row["pro_descripcion"];
			$precio=$row["pro_precio"];
			$cantidad=$row["pro_cantidad"];
			$precio2=number_format($precio);
			echo "
			<form method='POST'>
				<tr><td>$nombre</td><td>$precio2 Gs.</td>
				<td><select name='cantidad' style='font-size: 16px;'>
					<option>Cantidad</option>";

				for($i=1; $i <=$cantidad ; $i++) {echo"<option value='$i'>$i</option>";}

				echo "
				</select></td>
				<input type='hidden' name='cantidad_original' value='$cantidad'>
				<input type='hidden' name='codigo_pro' value='$codigo_producto'>
				<input type='hidden' name='precio' value='$precio'>
				<td><input class='boton' type='submit' name='agregar' value='Agregar'></td></tr>
				
			</form>";
			
		}
		echo "
		<tr><td colspan=2>
		<form method='POST'> 
			<input class='boton' name='finalizar' value='Finalizar Compra' type='submit'>
		</form></td></tr>
		</table>

		<br>Carrito<br><br>
		<table>";

		$carrito="SELECT * FROM solicitud,solicitud_detalle,producto WHERE solicitud_detalle.pro_codigo=producto.pro_codigo
		and solicitud_detalle.sol_codigo=solicitud.sol_codigo and solicitud.est_codigo=1 and cli_codigo=$codigocliente 
		ORDER BY sol_det_codigo";
		$res = mysqli_query($conexion, $carrito);
		$t=0;

		while ($row = mysqli_fetch_array($res)) {
			$medicametos=$row["pro_descripcion"];
			$cantidades=$row["sol_det_cantidad"];
			$cantidad_original=$row["pro_cantidad"];
			$sub_totales=$row["sol_det_subtotal"];
			$cod_pro_eli=$row["sol_det_codigo"];
			$cod_pro=$row["pro_codigo"];
			$t=$t+$sub_totales;

			echo "
			<form method='POST'>
				<tr><td>$medicametos</td><td>$cantidades Unid.</td><td>$sub_totales</td>
				<td>
				<input name='codigoeliminar' type='hidden' value='$cod_pro_eli'>
				<input name='codigoproducto' type='hidden' value='$cod_pro'>
				<input name='cantidad' type='hidden' value='$cantidades'>
				<input name='cantidad_original' type='hidden' value='$cantidad_original'>
				<input name='eliminar' class='boton' type='submit' value='Eliminar'>
				</td></tr>
			</form>";
		}

		$pt=number_format($t);
		echo "
		<tr><td colspan='2'>Total:</td><td>$pt</td></tr>
		</table>";

	}else{
		echo "
		<form method='POST'> 
			<input name='nuevo' value='Nuevo pedido' class='boton' type='submit'>	
		</form>";
	}

}else{
	
	echo "
	<head>		
		<META HTTP-EQUIV=Refresh CONTENT='5; URL=index.php'>
		<title>FarmaciaDAM(enIngles) Drugstore D.A.M.</title>
	</head>
	<body>

	Porfavor Inicie Sesion.<br>
	En Cinco Segundos volvera al inicio.

	</body>";

}

?>
