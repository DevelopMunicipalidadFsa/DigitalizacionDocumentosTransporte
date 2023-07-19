<?php
require_once '../Controladores/ControladorDigitalizacionExp.php';
require_once '../Modelos/ModelosDigitalizacionExp.php';
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<!-- Logo/icono de pagina -->
	<link rel="shortcut icon" type="image/x-icon" href="../Librerias/img/logoMunicipalidadFsa.png">
	<!--=====================================
	=              ARCHIVOS CSS         =
	======================================-->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
	<!-- <link rel="stylesheet" href="../Librerias/css/font-awesome.4.7.min.css"> -->
	<link rel="stylesheet" href="../Librerias/css/FontAwesome/all.min.css">
	<link rel="stylesheet" href="../Librerias/css/Estilos/stylePlantillas.css">
	<link rel="stylesheet" href="../Librerias/css/Estilos/styleFiltrarDominios.css">
	<link rel="stylesheet" href="../Librerias/css/Estilos/stylePeriodos.css">
	<link rel="stylesheet" href="../Librerias/css/Estilos/Responsive.css">
	<link rel="stylesheet" href="../Librerias/css/Estilos/Modales.css">
	<link rel="stylesheet" href="../Librerias/css/Select2/select2.css">
	<link rel="stylesheet" href="../Librerias/css/Bootstrap5/bootstrap-select.min.css">
	<link rel="stylesheet" href="../Librerias/css/Bootstrap5/bootstrap.min.css">



	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js" />
	</script>
	<script src="../Librerias/js/Scripts/jquery-3.5.1.min.js"></script>
	<script src="../Librerias/js/SweetAlert/sweetalert.2.10.js"></script>
	<script src="../Librerias/js/Bootstrap4/bootstrap.4.4.1.min.js"></script>
	<!-- <script src="../Librerias/js/Bootstrap5/bootstrap.min.js"></script> -->
	<script src="../Librerias/js/Select2/select2.js"></script>
	<script src="../Librerias/js/Select2/select2.min.js"></script>
	<title>Sistema de Digitalización Remises</title>
</head>

<body>
	<?php include_once('../nav.php') ?>
	<center>
		<div class="divContenedor">
			<div class="divGeneral">

				<?php
				if (isset($_GET['pagina'])) {
					if (
						$_GET['pagina'] == "Modulos/GestionRemises" ||
						$_GET['pagina'] == "Modulos/ResolucionesChoferes" ||
						$_GET['pagina'] == "Visualizar/VerImagen" ||
						$_GET['pagina'] == "Modulos/FiltrarPeriodos" ||
						$_GET['pagina'] == "Modulos/FiltrarDominios" ||
						$_GET['pagina'] == "Modulos/Periodo" ||
						$_GET['pagina'] == "Modulos/DigitalizarDocumentos"
					) {
						include_once "Paginas/" . $_GET['pagina'] . ".php";
					}
				} else {
					include_once "../index.php";
				}
				?>
			</div>
		</div>
	</center>


	<div class="footer">
		<?php include_once('../footer.php'); ?>
	</div>

	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
	<script src="../Librerias/js/Scripts/script.js"></script>

</body>
</html>