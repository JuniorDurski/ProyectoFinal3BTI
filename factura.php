<?php
include("conexion.php");
session_start();
error_reporting(0);

$usuarioactivo=$_SESSION["usuarioactivo"];
$bloqueoempleado=$_SESSION["bloqueoempleado"];
$codigocliente=$_SESSION["codigo_cliente"];
$f=$_SESSION["factura"];

if ($bloqueoempleado==1) {header("Location:administracion/");}

if($usuarioactivo==1 and $bloqueoempleado!=1){
	require 'menu.ctp';
	echo "<head>
	    <meta charset='utf-8'>
	    <title></title>

	    <link rel='stylesheet' href='css/template.css'>
	  </head><body>";

	if ($f==1) {
		$cabezera="SELECT * FROM solicitud where cli_codigo=$codigocliente ORDER BY sol_codigo DESC limit 1";
		$res = mysqli_query($conexion, $cabezera);
			
		while($row = mysqli_fetch_array($res)) {
			$codigo_solicitud=$row["sol_codigo"];
			$fecha=$row["sol_instante_pedido"];
			$total_f=$row["sol_total"];
		}

		$ins_cabezera="INSERT INTO factura(fac_codigo,fac_obs,fac_fecha,fac_total,cli_codigo,emp_codigo,est_codigo,sol_codigo)
		values(NULL,'','$fecha','$total_f','$codigocliente','',3,'$codigo_solicitud')";
		mysqli_query($conexion,$ins_cabezera);

		$cod="SELECT * FROM factura where sol_codigo=$codigo_solicitud ORDER BY fac_codigo limit 1";
		$res = mysqli_query($conexion, $cod);

		while($row = mysqli_fetch_array($res)) {
			$codigo_factura=$row["fac_codigo"];
		}

		$detalle="SELECT * FROM solicitud_detalle,producto where solicitud_detalle.pro_codigo=producto.pro_codigo 
		and sol_codigo=$codigo_solicitud";
		$res = mysqli_query($conexion, $detalle);

		while($row = mysqli_fetch_array($res)) {
			$producto=$row["pro_codigo"];
			$subtotal=$row["sol_det_subtotal"];
			$cantidad=$row["sol_det_cantidad"];

			$ins_detalle="INSERT INTO factura_detalle(fac_det_codigo,fac_codigo,pro_codigo, fac_det_subtotal, fac_det_cantidad)
			values(NULL,$codigo_factura,$producto,$subtotal,$cantidad)";
			mysqli_query($conexion,$ins_detalle);
		}
		
		$pago="INSERT INTO pago(pago_codigo,pago_monto,cli_codigo,pago_fecha,fac_codigo)
		values(NULL,'$total_f','$codigocliente',SYSDATE(),'$codigo_factura')";
		mysqli_query($conexion,$pago);

		$_SESSION["factura"]=2;
		header("Location:menu.php");
	}

	$busqueda="SELECT * FROM cliente,factura where factura.cli_codigo=cliente.cli_codigo and cliente.cli_codigo=$codigocliente";
	$res = mysqli_query($conexion, $busqueda);

	while($row = mysqli_fetch_array($res)) {
		
		$ape=$row["cli_apellido"];
		$nom=$row["cli_nombre"];
		$ruc=$row["cli_ruc"];
		$dir=$row["cli_direccion"];
		$co=$row["cli_correo"];
		$nro=$row["fac_codigo"];
		$fecha=$row["fac_fecha"];
		$total=$row["fac_total"];
		echo "<section id='invoice-title-number'>

	          <div class='title-top'>
	            <span></span> 
	          </div>
	          <div id='title'>FarmaciaDam </div><br>
	        
	          <div id='title'>Factura Nro:$nro</div>
	          
	        </section>
	        
	        <div class='clearfix'></div>
	        
	        <section id='invoice-info'>
	          <div>
	            <span>Cliente:</span> <span>$nom $ape</span>
	          </div>
	          <div>
	            <span>Fecha:</span> <span>$fecha</span>
	          </div>
	          <div>
	            <span>Direccion:</span> <span>$dir</span>
	          </div>
	          <div>
	            <span>Correo:</span> <span>$co</span>
	          </div>
	        </section>";

		
		echo "<section id='items'>
          
          <table cellpadding='5' cellspacing='5'>
          
            <tr>
              <th>Codigo</th>
              <th></th>
              <th>Producto</th>
              <th>Precio</th>
              <th>Cantidad</th>
              <th>Subtotal</th>
          
            </tr>";

		$busqueda_detalle="SELECT * FROM factura_detalle,producto 
		where factura_detalle.pro_codigo=producto.pro_codigo 
		and factura_detalle.fac_codigo=$nro";
		$res2 = mysqli_query($conexion, $busqueda_detalle);

		while($row2 = mysqli_fetch_array($res2)) {
		
			$productonombre=$row2["pro_descripcion"];
			$productoprecio=$row2["pro_precio"];
			$cod=$row2["pro_precio"];
			$subtotal=$row2["fac_det_subtotal"];
			$cantidad=$row2["fac_det_cantidad"];
			echo "<tr data-iterate='item'>
              <td>$cod</td>
              <td></td>
              <td>$productonombre</td>
              <td>$productoprecio</td>
              <td>$cantidad</td>
              <td>$subtotal</td>
            </tr>";			
		}
		echo "</table>
          
        </section>
        
        <section id='sums'>
        
          <table cellpadding='0' cellspacing='0'>
            
            <tr class='amount-total'>
              <td colspan='2'>Total:$total Gs.</td>
            </tr>
                        
          </table>
         </section><br><br><br><br><br><br>
         <form method='POST' action='facturacliente.php'>
		<input type='hidden' value='$nro' name='codigo'>
		<input type='submit' value='Imprimir Factura' class='btn' >
		</form><br><br>";

	}
}else{

	echo "
	<head>		
		<META HTTP-EQUIV=Refresh CONTENT='5; URL=../index.php'>
		<title>FarmaciaDAM(enIngles) Drugstore D.A.M.</title>
	</head>
	<body>

	Porfavor Inicie Sesion.<br>
	En Cinco Segundos volvera al inicio.

	</body>";

}

?>