<!--=====================================
	=              ARCHIVOS CSS         =
	======================================-->
	<link rel="stylesheet" href="Librerias/css/bootstrap.4.4.1.min.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">	
	<!-- <link rel="stylesheet" href="../Librerias/css/font-awesome.4.7.min.css"> -->
	
	<link rel="stylesheet" href="../Librerias/css/style.css">

	
	<script src="Librerias/js/jquery-3.5.1.min.js"></script>
	<script src="Librerias/js/sweetalert.2.10.js"></script>
	<script src="Librerias/js/bootstrap.4.4.1.min.js"></script>


<?php 

require_once 'Controladores/ControladorDigitalizacionExp.php';
require_once 'Modelos/ModelosDigitalizacionExp.php';	
//Se abre el código php para lo que es el inicio de la sesión
//Se reanuda la sesion que se abrió en ValidaLogin.php
if (isset($_REQUEST['username']) && isset($_REQUEST['clave'])) {

	$logueo=DigiExpedientesControlador::ctrLogueo();

		foreach ($logueo as $value): 
			$Codusu = $value[0];
			$Usuario = $value[1];
			$IdArea = $value[2];
			$Nivel = $value[3];
		endforeach;
		if($Usuario == true){
		// //Si los datos coinciden, se crea una sesión para el usuario
		// //Comienza la sesión
			session_start();
		// //Se crean las variables de la sesión
		// // inicio la sesión
			$_SESSION["autentificado"]= "SI";
		// //defino la sesión que demuestra que el usuario está autorizado
			$items2 = date("j-n-Y H:i:s",time());
			$date = new DateTime($items2, new DateTimeZone('America/Argentina/Buenos_Aires'));
			date_default_timezone_set('America/Argentina/Buenos_Aires');
			$zonahoraria = date_default_timezone_get();
			$items2=date("j-n-Y H:i:s",time());

			$_SESSION["ultimoAcceso"]= $items2;
		// //defino la fecha y hora de inicio de sesión en formato aaaa-mm-dd hh:mm:ss
			$_SESSION['nombre'] =$Usuario;
			$_SESSION['codusu'] =$Codusu;
			$_SESSION['IdArea'] =$IdArea;
		// //Redirecciona a la página principal
			header("Location:Vistas/plantillas.php?pagina=Modulos/GestionRemises");


		}else{
			?>
			<script>	
				jQuery(function(){
					Swal.fire({
					icon: 'error',
					title: '¡Error!',
					text: 'Clave incorrecta',
					showConfirmButton: true, 
					confirmButtonText: 'Ok'
					}).then((result) => {
					  /* Read more about isConfirmed, isDenied below */
					  if (result.isConfirmed) {
					     window.history.go(-1);
					  }
					})
				});
			</script>
	<?php
		}	
}?>
</body>