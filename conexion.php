<?php
//gonza proyectodrone 
$basedatos="proyecto";
$user="root";
$pass="";
$server="localhost";

$conexion=mysqli_connect($server,$user,$pass,$basedatos);

try{
	$PDO=new PDO("mysql:host=$server;dbname=$basedatos","$user","$pass");

}catch(PDOExeption $err){
echo $err->getMessage();
}

?>