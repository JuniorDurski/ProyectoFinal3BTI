<!DOCTYPE html>
<html lang="en">
<head>
	<title>DrugStore D.A.M.</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="phpThumb_generated_thumbnailico.ico">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="registrarse/css/util.css">
	<link rel="stylesheet" type="text/css" href="registrarse/css/main.css">
</head>
<body>
	<?php 
	include("conexion.php");

	if (!empty($_POST['registrarse'])) {
		$nombre=$_POST["nombre"];
		$apellido=$_POST["apellido"];
		$cedula=$_POST["cedula"];
		$usuario=$_POST["usuario"];
		$clave=$_POST["clave"];
		$clave_confirmar=$_POST["clave_confirmar"];
		$correo=$_POST["correo"];
		$targeta=$_POST["targeta"];
		$ruc=$_POST["ruc"];
		$clave_targeta=$_POST["clave_targeta"];
		$direccion=$_POST["direccion"];

		if ($clave==$clave_confirmar) {

			$DesdeLetra = "a";
			$HastaLetra = "z";
			$DesdeNumero = 1;
			$HastaNumero = 99999;

			$letraAleatoria = chr(rand(ord($DesdeLetra), ord($HastaLetra)));
			$numeroAleatorio = rand($DesdeNumero, $HastaNumero);
			$nro=$letraAleatoria.$numeroAleatorio;

			
			$agregar="INSERT INTO cliente(cli_codigo,cli_ci,cli_nombre,cli_apellido,cli_usuario,cli_clave,
			cli_ruc,cli_tarjeta, cli_clave_tarjeta, cli_correo, cli_direccion, cli_confirmar, est_codigo)
			VALUES(NULL, '$cedula', '$nombre', '$apellido', '$usuario', '$clave', '$ruc', '$targeta', 
			'$clave_targeta','$correo', '$direccion', '$nro', 3);";
			mysqli_query($conexion,$agregar);

			$msg="Verifique su correo dando click aqui:"."\r\n";
			$msg="http://damprototype.com/correo.php?cof=$nro";
			mail($correo,"Confirmar Correo",$msg);
			
			echo "
			<head>		
				<META HTTP-EQUIV=Refresh CONTENT='3; URL=index.php'>
			</head>
			<body>

			<div class='alert alert-success'>
			  <strong>Maravilloso!</strong> Solo le falta confimar su correo.
			</div>

			</body>";

		}else{
			echo "
			<div class='alert alert-danger'>
			  <strong>Advertencia!</strong> Su contraseña no coincide.
			</div>";
			
		}

	}

	?>
	<form method="POST" >
	<div class="limiter">
		<div class="container-login100">
			<div class="login100-more" style="background-image: url('registrarse/fondo4.png');"></div>

			<div class="wrap-login100 p-l-50 p-r-50 p-t-72 p-b-50">
				<div class="login100-form validate-form"><!--form-->
					<span class="login100-form-title p-b-59">
						Registrarse
					</span>

					<div class="wrap-input100 validate-input" data-validate="Ingrese su Nombre">
						<span class="label-input100">Nombre</span>
						<input class="input100" type="text" name="nombre" placeholder="Nombre" required>
						<span class="focus-input100"></span>
					</div>
					<div class="wrap-input100 validate-input" data-validate="Ingrese su Apellido">
						<span class="label-input100">Apellido</span>
						<input class="input100" type="text" name="apellido" placeholder="Apellido" required>
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Coloque su Cedula">
						<span class="label-input100">Cedula</span>
						<input class="input100" type="text" name="cedula" placeholder="Cedula" required>
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Correo invalido ej.: ex@abc.xyz">
						<span class="label-input100">Email</span>
						<input class="input100" type="email" name="correo" placeholder="Direccion de Email " required>
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Coloque su Direccion">
						<span class="label-input100">Direccion</span>
						<input class="input100" type="text" name="direccion" placeholder="Direccion" required>
						<span class="focus-input100"></span>
					</div>


					<div class="wrap-input100 validate-input" data-validate="Ingrese su Nombre de Usuario">
						<span class="label-input100">Usuario</span>
						<input class="input100" type="text" name="usuario" placeholder="Usuario" required>
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Ingrese una Contraseña">
						<span class="label-input100">Contraseña</span>
						<input class="input100" type="password" name="clave" placeholder="Contraseña" required>
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Confirme su Contraseña">
						<span class="label-input100">Confirmar Contraseña</span>
						<input class="input100" type="password" name="clave_confirmar" placeholder="Confirmar Contraseña" required>
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="ingrese el numero de tarjeta">
						<span class="label-input100">N° de Tarjeta</span>
						<input class="input100" type="text" name="targeta" placeholder="Numero de Tarjeta" required>
						<span class="focus-input100"></span>
					</div>
                                        
					<div class="wrap-input100 validate-input" data-validate="se requiere CVC">
						<span class="label-input100">CVC</span>
						<input class="input100" type="text" name="clave_targeta" placeholder="CVC" required>
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="ingrese el numero de tarjeta">
						<span class="label-input100">RUC</span>
						<input class="input100" type="text" name="ruc" placeholder="Numero de RUC" required>
						<span class="focus-input100"></span>
					</div>
						
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<input type="submit" name="registrarse" class="login100-form-btn" value="Registrarse" style="background-color:green">
						</div>

						<a href="index.php" class="dis-block txt3 hov1 p-r-30 p-t-10 p-b-10 p-l-30">
								Volver
							<i class="fa fa-long-arrow-right m-l-5"></i>
						</a>

					</div>
				</div>
			</div>
		</div>
	</div>
	</form>

</body>
</html>