<?php
session_start();
session_destroy();

?>
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
	<title>DrugStore D.A.M.</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
	<link rel="icon" type="image/png" href="phpThumb_generated_thumbnailico.ico">
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
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

					<div class="wrap-input100 validate-input m-b-16" data-validate="Ingrese su Usuario">
						<input class="input100" type="text" name="user" placeholder="Usuario" required>
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Ingrese su Contrase�a">
						<input class="input100" type="password" name="pass" placeholder="Clave" required>
						<span class="focus-input100"></span>
					</div>

					<div style="margin-top: 20px" class="container-login100-form-btn">
						<button class="login100-form-btn">
							Iniciar
						</button>
					</div>

					<div style="margin-top: -30px;margin-bottom: -20px" class="flex-col-c p-t-170 p-b-40">
						<span class="txt1 p-b-9">
							No tienes una cuenta?
						</span>

						<a href="registrarse.php" class="txt3">
							Registrarse
						</a>
						<span class="txt1 p-b-9">
							<a href="index.php" style="text-align:left;">
							Volver
							</a>
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