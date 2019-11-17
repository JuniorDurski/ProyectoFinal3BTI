<?php
include("conexion.php");
session_start();
error_reporting(0);
$usuarioactivo=$_SESSION["usuarioactivo"];
$bloqueoempleado=$_SESSION["bloqueoempleado"];
$codigo=$_SESSION["codigo_cliente"];

if ($bloqueoempleado==1) {header("Location:administracion/");}

if($usuarioactivo==1 and $bloqueoempleado!=1) {
	require 'menu.ctp';
	if (!empty($_POST["modificar"])) {
		$nombre=$_POST["nombre"];
		$apellido=$_POST["apellido"];
		$cedula=$_POST["cedula"];
		$usuario=$_POST["usuario"];
		$clave=$_POST["clave"];
		$clave_confirmar=$_POST["clave_confirmar"];
		$correo=$_POST["correo"];
		$targeta=$_POST["targeta"];
		$clave_targeta=$_POST["clave_targeta"];
		$direccion=$_POST["direccion"];
		$ruc=$_POST["ruc"];

		if ($clave==$clave_confirmar) {

			$modificar="UPDATE cliente SET cli_nombre='$nombre', cli_apellido='$apellido', cli_ci='$cedula', cli_direccion='$direccion',
			cli_correo='$correo', cli_usuario='$usuario', cli_clave='$clave', cli_tarjeta='$targeta', cli_ruc='$ruc', 
			cli_clave_tarjeta='$clave_targeta' WHERE cli_codigo = $codigo";
			
			mysqli_query($conexion,$modificar);

		}else{
			echo "<p style='color:red;'>La contraseña no coincide</p>";
		}
	}
	
	echo "Ajustes de cuenta<br>";

	$buscar="SELECT * FROM cliente where cli_codigo=$codigo";
	$res = mysqli_query($conexion, $buscar);
		
	while ($row = mysqli_fetch_array($res)) {
		$nom=$row["cli_nombre"];
		$ape=$row["cli_apellido"];
		$ced=$row["cli_ci"];
		$dir=$row["cli_direccion"];
		$cor=$row["cli_correo"];
		$usu=$row["cli_usuario"];
		$cla=$row["cli_clave"];
		$nrot=$row["cli_tarjeta"];
		$cvc=$row["cli_clave_tarjeta"];
		$ruc=$row["cli_ruc"];
	}	
	echo"
	<form method='POST'>
		<table>
        <tr><td>Nombre:</td><td><input type='text' required value='$nom' name='nombre'></td></tr>

        <tr><td>Apellido:</td><td><input type='text' required value='$ape' name='apellido'></td></tr>

        <tr><td>Cedula de identidad:</td><td><input type='text' required value='$ced' name='cedula'></td></tr>
        
        <tr><td>Direccion:</td><td><input type='text' required value='$dir' name='direccion'></td></tr>

        <tr><td>RUC:</td><td><input type='text' required value='$ruc' name='ruc'></td></tr>
        
        <tr><td>Correo:</td><td><input type='text' required value='$cor' name='correo'></td></tr>
        
        <tr><td>Usuario:</td><td><input type='text' required value='$usu' name='usuario'></td></tr>

        <tr><td>Contraseña:</td><td><input type='password' required value='$cla' name='clave'></td></tr>
        
        <tr><td>Confirmar Contraseña:</td><td><input type='password' required value='' name='clave_confirmar'></td></tr>
        
        <tr><td>Nro° de Targeta</td><td><input type='text' required value='$nrot' name='targeta'></td></tr>
        
        <tr><td>CVC:</td><td><input type='text' required value='$cvc' name='clave_targeta'></td></tr>
        
        <tr><th colspan=2>
		<input type='submit' name='modificar' value='Cambiar'></th></tr>
		</table>

	</form>";
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