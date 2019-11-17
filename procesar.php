<?php
session_start();
//error_reporting(0);

function verificar($tabla='',$usuario='',$clave='',$codigo='',$codigocookie='',$acceso='',$accesofecha='',$url=''){
	include("conexion.php");
	$user=$_POST["user"];
	$pass=$_POST["pass"];

	$query="SELECT * from $tabla where $usuario='$user' and $clave='$pass'";
	$res = mysqli_query($conexion, $query);

	while ($row = mysqli_fetch_array($res)) {
		$confirmacion=2;

		$codigobd=$row["$codigo"];
		$_SESSION["$codigocookie"]=$codigobd;

		if ($tabla == "empleado") {
			$confirmacion=1;
			$_SESSION["bloqueoempleado"]=1;	

			$query2="SELECT * from $tabla , tipo_empleado where empleado.tip_codigo=tipo_empleado.tip_codigo and emp_codigo=$codigobd";
			$res = mysqli_query($conexion, $query2);

			while ($row = mysqli_fetch_array($res)) {
				$tipoempleado=$row["tip_codigo"];
				$_SESSION["tipoempleado_codigo"]=$tipoempleado;
			}
		}
		
		$query3="SELECT * from cliente where $usuario='$user' and $clave='$pass' and est_codigo=1";
		$res = mysqli_query($conexion, $query3);
		
		while ($row = mysqli_fetch_array($res)) {
			$confirmacion=1;	
		}
		
		if ($confirmacion==1) {
			$_SESSION["usuarioactivo"]=1;
						
			$sql = "INSERT INTO $acceso($accesofecha,$codigo) VALUES (SYSDATE(),'$codigobd')";
			mysqli_query($conexion,$sql);

			header("Location:$url");
		}

		elseif($confirmacion==2) {
			header("Location:index.php");			
		}
				
	}
}

verificar("empleado","emp_usuario","emp_clave","emp_codigo","codigo_empleado","acceso_empleado","acc_emp_fecha","administracion/");
verificar("cliente","cli_usuario","cli_clave","cli_codigo","codigo_cliente","acceso_cliente","acc_cli_fecha","menu.php");
?>
<html>	

	<head>		

		<link rel="stylesheet" type="text/css" href="error.css">

		<META HTTP-EQUIV=Refresh CONTENT='5; URL=index.php'>

		<title>Drugstore D.A.M.</title>

		<meta name="viewport" content="width=device-width, initial-scale=1">

<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="phpThumb_generated_thumbnailico.ico">

<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->

	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">

	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">

	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">

	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">

	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">

	<link rel="stylesheet" type="text/css" href="css/util.css">

	</head>

	<body>

	<div class="limiter">

		<div class="container-login100" >

			<div class="move" >

			<marquee scrolldelay="200" BEHAVIOR="alternate">

			<img src="fondo7.png">

			</marquee>

	</div>

			<div class="wrap-login100">

				<form class="login100-form validate-form p-l-55 p-r-55 p-t-178" method="POST" action="procesar.php">

					<span class="login100-form-title">

						DrugStore D.A.M.

					</span>
					<div style="margin-top: -180px;margin-bottom: 20px" class="flex-col-c p-t-170 p-b-40">

						<span class="txt1 p-b-9">

							Por favor <br><a href="login.php" class="txt3">Inicie Sesion</a> o <a href="registrarse.php" class="txt3">Registrese</a><br>

							En Cinco Segundos volvera al inicio.

						</span>

					</div>

				</form>

			</div>

		</div>

	</div>

	

	

<!--===============================================================================================-->

	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>

<!--===============================================================================================-->

	<script src="vendor/animsition/js/animsition.min.js"></script>

<!--===============================================================================================-->

	<script src="vendor/bootstrap/js/popper.js"></script>

	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

<!--===============================================================================================-->

	<script src="vendor/select2/select2.min.js"></script>

<!--===============================================================================================-->

	<script src="vendor/daterangepicker/moment.min.js"></script>

	<script src="vendor/daterangepicker/daterangepicker.js"></script>

<!--===============================================================================================-->

	<script src="vendor/countdowntime/countdowntime.js"></script>

<!--===============================================================================================-->

	<script src="js/main.js"></script>
	</body>

</html>