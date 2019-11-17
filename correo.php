<?php
session_start();
include("conexion.php");

$codigo=$_REQUEST['cof'];

$consulta = "UPDATE cliente set est_codigo=2 where cli_confirmar=:COF";
$stmt = $PDO->prepare($consulta);
$stmt->bindParam(':COF',$codigo);

if($stmt->execute()){
	$datos = array("CREATE" => "MODIFICADO" );
}else{
	$datos = array("CREATE" =>"ERROR SQL" );
}

echo json_encode($datos);
header("Location:index.php");
?>