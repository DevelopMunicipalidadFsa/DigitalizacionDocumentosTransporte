<?php
class DigiExpedientesControlador
{

	public function ctrLogueo()
	{
		if (isset($_REQUEST['username']) && isset($_REQUEST['clave'])) {

			$username = $_REQUEST['username'];
			$clave = $_REQUEST['clave'];


			if ($username == true && $clave == true) {

				$rta = DigiExpedientesModelo::mdlLogueo($username, $clave);

				return $rta;
			}
		}
	}

	public function ctrAltaArchivo()
	{
		if (isset($_REQUEST['FormularioAltaArchivoParticular'])) {

			$image = $_FILES["image"];
			$Archivo = $_FILES["image"]['name'];
			$rutaTemp = $_FILES['image']['tmp_name'];
			$extencion = $_FILES['image']['type'];

			$idAdherente = $_REQUEST['Ia'];
			$idRequisito = $_REQUEST['Ir'];
			$descripcion = "DIR. TRANSPORTE";
			$Usuario = $_REQUEST['Us'];
			$codUsu = $_REQUEST['Cus'];
			$dniChofer = $_REQUEST['Dc'];
			$Agencia = rtrim($agencia = $_REQUEST['Ag']);
			$idAgencia = $_REQUEST['Iag'];
			$Vdesde = $_REQUEST['Vd'];
			$Vhasta = $_REQUEST['Vh'];
			$url = $_REQUEST['Ul'];
			$Do = $_REQUEST['Do'];
			$dominio = rtrim($Do = $_REQUEST['Do']);
			$titulo = $_REQUEST['Ti'];

			$explode = explode(".", $_FILES["image"]['name']);
			$NombreArchivo = $titulo . "_" . $dniChofer . "." . end($explode);

			$id_adherente = $_REQUEST['id_adherente'];

			$rta = DigiExpedientesModelo::mdlAltaArchivo($idAdherente, $idRequisito, "$titulo", "$dominio", "$descripcion", "$rutaTemp", "$extencion", "$Usuario", $codUsu, $Vdesde, $Vhasta, "$Agencia", $idAgencia, "$NombreArchivo");

			if ($url == "Periodo") {
				$name = "Periodo"; ?>
				<form action="plantillas.php?pagina=Modulos/Periodo" name="Periodo" method="post">
					<input type="hidden" name="Vh" value="<?php echo $Vhasta = $_REQUEST['Vh']; ?>">
					<input type="hidden" name="Vd" value="<?php echo $Vdesde = $_REQUEST['Vd']; ?>">
					<input type="hidden" name="Do" value="<?php echo $dominio = $_REQUEST['Do']; ?>">
					<input type="hidden" name="Ia" value="<?php echo $idAdherente = $_REQUEST['Ia']; ?>">
					<input type="hidden" name="Iag" value="<?php echo  $idAgencia = $_REQUEST['Iag']; ?>">
					<input type="hidden" name="Dc" value="<?php echo $dniChofer = $_REQUEST['Dc']; ?>">
					<input type="hidden" name="Ag" value="<?php echo $Vdesde = $_REQUEST['Ag']; ?>">
					<input type="hidden" name="Iru" value="<?php echo 0 ?>">
					<input type="hidden" name="Itr" value="<?php echo 8 ?>">
					<input type="hidden" name="id_adherente" value="<?php echo $id_adherente ?>">

				</form>
			<?php }

			if ($url == "DigitalizarDocumentos") {
				$name = "DigitalizarDocumentos"; ?>
				<form action="plantillas.php?pagina=Modulos/DigitalizarDocumentos" method="post" name="DigitalizarDocumentos">
					<input type="hidden" name="Do" value="<?php echo $dominio = $_REQUEST['Do']; ?>">
					<input type="hidden" name="Ia" value="<?php echo $idAdherente = $_REQUEST['Ia']; ?>">
					<input type="hidden" name="Iag" value="<?php echo  $idAgencia = $_REQUEST['Iag']; ?>">
					<input type="hidden" name="Dc" value="<?php echo $dniChofer = $_REQUEST['Dc']; ?>">
					<input type="hidden" name="Iru" value="<?php echo 0 ?>">
					<input type="hidden" name="Itr" value="<?php echo 8 ?>">
					<input type="hidden" name="Ag" value="<?php echo $Vdesde = $_REQUEST['Ag']; ?>">
					<input type="hidden" name="Vd" value="<?php echo $Vdesde = $_REQUEST['Vd']; ?>">
					<input type="hidden" name="Vh" value="<?php echo $Vhasta = $_REQUEST['Vh']; ?>">
				</form>

			<?php } ?>

			<?php if ($rta == 'ok') {
				echo "<script>
				if (window.history.replaceState) {
					window.history.replaceState(null, null, window.location.href);
				}
				</script>";
				echo "<script>	
							jQuery(function(){
								Swal.fire({
									icon: 'success',
									title: '¡Muy bien!',
									text: 'El documento se digitalizó correctamente',
									showConfirmButton: true
									}).then((result) => {
										document.$name.submit();
								})
							});
					</script>";
			} else {
				echo "<script>	
							jQuery(function(){
								Swal.fire({
									icon: 'error',
									title: '¡Algo no anda bien!',
									text: 'No se pudo digitalizar el documento',
									showConfirmButton: true
									}).then((result) => {
										document.$name.submit();
								})
							});
					</script>";
			}
		}
	}


	public function ctrBajaArchivo()
	{
		if (isset($_REQUEST['Ie']) && isset($_REQUEST['Ul'])) {
			$url = $_REQUEST['Ul'];
			$idDocumento = $_REQUEST['Ie'];

			$archivo = $_REQUEST['Ach'];
			$idAdherente = $_REQUEST['Ia'];
			$Do = $_REQUEST['Do'];
			$dominio = rtrim($Do = $_REQUEST['Do']);
			$Usuario = $_REQUEST['Us'];
			$codUsu = $_REQUEST['Cus'];
			$idAgencia = $_REQUEST['Iag'];
			$dniChofer = $_REQUEST['Dc'];
			$creacion = $_REQUEST['Cre'];
			$agencia = $_REQUEST['Ag'];
			$Agencia = rtrim($agencia);
			$Vdesde = $_REQUEST['Vd'];
			$Vhasta = $_REQUEST['Vh'];

			$anio = date("Y", strtotime($creacion));
			$periodoAnio = date("Y", strtotime($creacion));
			$periodoMes = date("m", strtotime($creacion));
			$periodo = "$periodoAnio$periodoMes";
			$NombreArchivo = $_REQUEST['Na'];

			$id_adherente = $_REQUEST['id_adherente'];

			$rta = DigiExpedientesModelo::mdlBajaArchivo($idDocumento, $idAdherente, $dominio, $Usuario, $codUsu, $Agencia, $anio, $periodo, $NombreArchivo);

			if ($url == "ResolucionesChoferes") {
				$nameB = "Rc";
			?>
				<form action="plantillas.php?pagina=Modulos/ResolucionesChoferes" name="Rc" method="post">
					<input type="hidden" name="Do" value="<?php echo $dominio = $_REQUEST['Do']; ?>">
					<input type="hidden" name="Ia" value="<?php echo $idAdherente = $_REQUEST['Ia']; ?>">
					<input type="hidden" name="Iag" value="<?php echo  $idAgencia = $_REQUEST['Iag']; ?>">
					<input type="hidden" name="Dc" value="<?php echo $dniChofer = $_REQUEST['Dc']; ?>">
				</form>
			<?php } else if ($url == "FiltrarFechas") {
				$nameB = "Ff";
			?>
				<form action="plantillas.php?pagina=Modulos/FiltrarPeriodos" name="Ff" method="post">
					<input type="hidden" name="Vh" value="<?php echo $Vhasta = $_REQUEST['Vh']; ?>">
					<input type="hidden" name="Vd" value="<?php echo $Vdesde = $_REQUEST['Vd']; ?>">
					<input type="hidden" name="Do" value="<?php echo $dominio = $_REQUEST['Do']; ?>">
					<input type="hidden" name="Ia" value="<?php echo $idAdherente = $_REQUEST['Ia']; ?>">
					<input type="hidden" name="Iag" value="<?php echo  $idAgencia = $_REQUEST['Iag']; ?>">
					<input type="hidden" name="Dc" value="<?php echo $dniChofer = $_REQUEST['Dc']; ?>">
					<input type="hidden" name="Ag" value="<?php echo $agencia = $_REQUEST['Ag']; ?>">
				</form>
			<?php } else if ($url == "VerPeriodosFiltrados") {
				$idTramite = $_REQUEST['Itr'];
				$idRubro = $_REQUEST['Iru'];
				$nameB = "Pf"; ?>
				<form action="plantillas.php?pagina=Modulos/Periodo" name="Pf" method="post">
					<input type="hidden" name="Vh" value="<?php echo $Vhasta = $_REQUEST['Vh']; ?>">
					<input type="hidden" name="Vd" value="<?php echo $Vdesde = $_REQUEST['Vd']; ?>">
					<input type="hidden" name="Do" value="<?php echo $dominio = $_REQUEST['Do']; ?>">
					<input type="hidden" name="Ia" value="<?php echo $idAdherente = $_REQUEST['Ia']; ?>">
					<input type="hidden" name="Iag" value="<?php echo  $idAgencia = $_REQUEST['Iag']; ?>">
					<input type="hidden" name="Dc" value="<?php echo $dniChofer = $_REQUEST['Dc']; ?>">
					<input type="hidden" name="Ag" value="<?php echo $Vdesde = $_REQUEST['Ag']; ?>">
					<input type="hidden" name="Iru" value="<?php echo $idTramite ?>">
					<input type="hidden" name="Itr" value="<?php echo $idRubro ?>">
				</form>
			<?php } else if ($url == "DigitalizarDocumentos") {
				$nameB = "Dd"; ?>
				<form action="plantillas.php?pagina=Modulos/DigitalizarDocumentos" method="post" name="Dd">
					<input type="hidden" name="Do" value="<?php echo $dominio = $_REQUEST['Do']; ?>">
					<input type="hidden" name="Ia" value="<?php echo $idAdherente = $_REQUEST['Ia']; ?>">
					<input type="hidden" name="Iag" value="<?php echo  $idAgencia = $_REQUEST['Iag']; ?>">
					<input type="hidden" name="Dc" value="<?php echo $dniChofer = $_REQUEST['Dc']; ?>">
					<input type="hidden" name="Iru" value="<?php echo 0 ?>">
					<input type="hidden" name="Itr" value="<?php echo 8 ?>">
					<input type="hidden" name="Ag" value="<?php echo $Vdesde = $_REQUEST['Ag']; ?>">
					<input type="hidden" name="Vd" value="<?php echo $Vdesde = $_REQUEST['Vd']; ?>">
					<input type="hidden" name="Vh" value="<?php echo $Vhasta = $_REQUEST['Vh']; ?>">
				</form>

			<?php } else if ($url == "Periodo") {
				$nameB = "Periodo"; ?>
				<form action="plantillas.php?pagina=Modulos/Periodo" name="Periodo" method="post">
					<input type="hidden" name="Vh" value="<?php echo $Vhasta = $_REQUEST['Vh']; ?>">
					<input type="hidden" name="Vd" value="<?php echo $Vdesde = $_REQUEST['Vd']; ?>">
					<input type="hidden" name="Do" value="<?php echo $dominio = $_REQUEST['Do']; ?>">
					<input type="hidden" name="Ia" value="<?php echo $idAdherente = $_REQUEST['Ia']; ?>">
					<input type="hidden" name="Iag" value="<?php echo  $idAgencia = $_REQUEST['Iag']; ?>">
					<input type="hidden" name="Dc" value="<?php echo $dniChofer = $_REQUEST['Dc']; ?>">
					<input type="hidden" name="Ag" value="<?php echo $Vdesde = $_REQUEST['Ag']; ?>">
					<input type="hidden" name="Iru" value="<?php echo 0 ?>">
					<input type="hidden" name="Itr" value="<?php echo 8 ?>">
					<input type="hidden" name="id_adherente" value="<?php echo $id_adherente ?>">

				</form>
			<?php }
			if ($rta == 'ok') {
				echo "<script>	
						jQuery(function(){
							Swal.fire({
								icon: 'success',
								title: '¡Muy bien!',
								text: 'El documento se eliminó correctamente',
								showConfirmButton: true
								}).then((result) => {
									document.$nameB.submit()
							})
						});
				</script>";
			} else {
				echo "<script>	
						jQuery(function(){
							Swal.fire({
								icon: 'error',
								title: '¡Algo no anda bien!',
								text: 'No se pudo borrar el documento',
								showConfirmButton: true
								}).then((result) => {
									document.$nameB.submit()
							})
						});
				</script>";
			}
		}
	}

	public function CtrlAltaMasiva()
	{
		if (isset($_POST['FormularioAltaMasiva'])) {
			$url = $_POST['Ul'];

			if ($url == "Periodo") {
				$name = "Periodo"; ?>
				<form action="plantillas.php?pagina=Modulos/Periodo" name="Periodo" method="post">
					<input type="hidden" name="Vh" value="<?php echo $Vhasta = $_REQUEST['Vh']; ?>">
					<input type="hidden" name="Vd" value="<?php echo $Vdesde = $_REQUEST['Vd']; ?>">
					<input type="hidden" name="Do" value="<?php echo $dominio = $_REQUEST['Do']; ?>">
					<input type="hidden" name="Ia" value="<?php echo $idAdherente = $_REQUEST['Ia']; ?>">
					<input type="hidden" name="Iag" value="<?php echo  $idAgencia = $_REQUEST['Iag']; ?>">
					<input type="hidden" name="Dc" value="<?php echo $dniChofer = $_REQUEST['Dc']; ?>">
					<input type="hidden" name="Ag" value="<?php echo $Vdesde = $_REQUEST['Ag']; ?>">
					<input type="hidden" name="Iru" value="<?php echo 0 ?>">
					<input type="hidden" name="Itr" value="<?php echo 8 ?>">
					<input type="hidden" name="id_adherente" value="<?php echo $_POST['id_adherente'] ?>">

				</form> <?php
						if ($url == "DigitalizarDocumentos") {
							$name = "DigitalizarDocumentos"; ?>
					<form action="plantillas.php?pagina=Modulos/DigitalizarDocumentos" method="post" name="DigitalizarDocumentos">
						<input type="hidden" name="Do" value="<?php echo $dominio = $_REQUEST['Do']; ?>">
						<input type="hidden" name="Ia" value="<?php echo $idAdherente = $_REQUEST['Ia']; ?>">
						<input type="hidden" name="Iag" value="<?php echo  $idAgencia = $_REQUEST['Iag']; ?>">
						<input type="hidden" name="Dc" value="<?php echo $dniChofer = $_REQUEST['Dc']; ?>">
						<input type="hidden" name="Iru" value="<?php echo 0 ?>">
						<input type="hidden" name="Itr" value="<?php echo 8 ?>">
						<input type="hidden" name="Ag" value="<?php echo $Vdesde = $_REQUEST['Ag']; ?>">
						<input type="hidden" name="Vd" value="<?php echo $Vdesde = $_REQUEST['Vd']; ?>">
						<input type="hidden" name="Vh" value="<?php echo $Vhasta = $_REQUEST['Vh']; ?>">
					</form>

<?php }

						for ($i = 0; $i < count($_POST["Ir"]); $i++) {
							if ($_FILES['image']["name"][$i] != null || $_FILES['image']["name"][$i] != "") {
								// $Vd = $_POST['Vd'];
								// $Vh = $_POST['Vh'];
								// $Do = $_POST['Do'];
								// $Us = $_POST['Us'];
								// $Cus = $_POST['Cus'];
								// $Iag = $_POST['Iag'];
								// $Ag = $_POST['Ag'];
								// $id_adherente = $_POST['id_adherente'];
								// $Itr = $_POST['Itr'];
								// $Iru = $_POST['Iru'];
								// $Dc = $_POST['Dc'];
								// $image[$i];
								// $rutaTemportal[$i];
								// $imageTipo[$i];
								// $imagenes = $_FILES['image'];
								// $id[$i];
								// $titulo[$i];
								// echo "<br>" . $imagenes[$i];

								$image = $_FILES['image']["name"][$i];
								$rutaTemp = $_FILES['image']["tmp_name"][$i];
								$extencion = $_FILES['image']["type"][$i];


								$idAdherente = $_POST['Ia'];
								$idRequisito = $_POST['Ir'][$i];
								$titulo = $_POST['Ti'][$i];
								$dominio = rtrim($Do = $_REQUEST['Do']);
								$descripcion = "DIR. TRANSPORTE";
								$Usuario = $_REQUEST['Us'];
								$codUsu = $_REQUEST['Cus'];
								$Vdesde = $_REQUEST['Vd'];
								$Vhasta = $_REQUEST['Vh'];
								$Agencia = rtrim($agencia = $_REQUEST['Ag']);

								$dniChofer = $_REQUEST['Dc'];
								$idAgencia = $_REQUEST['Iag'];
								$url = $_REQUEST['Ul'];
								$Do = $_REQUEST['Do'];

								$explode = explode(".", $_FILES["image"]['name'][$i]);
								$NombreArchivo = $titulo . "_" . $dniChofer . "." . end($explode);

								$id_adherente = $_REQUEST['id_adherente'];

								$rta = DigiExpedientesModelo::mdlAltaArchivoMasivo($idAdherente, $idRequisito, "$titulo", "$dominio", "$descripcion", "$rutaTemp", "$extencion", "$Usuario", $codUsu, $Vdesde, $Vhasta, "$Agencia", $idAgencia, "$NombreArchivo");

								if ($rta == 'ok') {
									echo "<script>
									if (window.history.replaceState) {
										window.history.replaceState(null, null, window.location.href);
									}
									</script>";
									echo "<script>	
												jQuery(function(){
													Swal.fire({
														icon: 'success',
														title: '¡Muy bien!',
														text: 'El documento se digitalizó correctamente',
														showConfirmButton: true
														}).then((result) => {
															document.$name.submit();
													})
												});
										</script>";
								} else {
									echo "<script>	
												jQuery(function(){
													Swal.fire({
														icon: 'error',
														title: '¡Algo no anda bien!',
														text: 'No se pudo digitalizar el documento',
														showConfirmButton: true
														}).then((result) => {
															document.$name.submit();
													})
												});
										</script>";
								}
							}
						}
					}
				}
			}
		}



		class ControladorAgencias
		{
			static public function CtrMostrarAgencias()
			{
				$arreglo = array();
				$respuesta = ModeloAgencias::listarAgencias();

				foreach ($respuesta as $agencias) {
					$arreglo[] = $agencias;
				}
				return $respuesta;
			}
		}

		class ControladorDominios
		{
			static public function CtrMostrarDominios()
			{
				$id_agencia = $_POST['id_agencia'];
				$dominios = array();
				$respuesta = ModeloDominios::MdlMostrarDominios($id_agencia);
				foreach ($respuesta as $fila) {
					$dominios[] = $fila;
				}

				return $dominios;
			}
		}

		class ControladorChoferes
		{
			static public function CtrMostrarChoferes()
			{
				$dominio = $_POST['dominio'];
				$choferes = array();
				$respuesta = ModeloChoferes::MdlMostrarChoferes($dominio);

				foreach ($respuesta as $chofer) {
					$choferes[] = $chofer;
				}

				if (!empty($respuesta)) {
					return $choferes;
				} else {
					return false;
				}
			}
		}

		class ControladorTitularVehiculo
		{
			static public function CtrMostrarDatosTitularVehiculo()
			{
				if (isset($_REQUEST['Do'])) {
					$dominio = $_REQUEST['Do'];

					$titulares = array();
					$respuesta = ModeloTitularVehiculo::MdlMostrarDatosTitularVehiculo($dominio);

					foreach ($respuesta as $dato) {
						$titulares[] = $dato;
					}

					if (!empty($respuesta)) {
						return $titulares;
					} else {
						return false;
					}
				}
			}
		}

		class ControladorDatosChofer
		{
			static public function CtrMostarDatosChofer()
			{
				if (isset($_REQUEST['Ia'])) {
					$id_adherente = $_REQUEST['Ia'];

					$adherente = array();
					$respuesta = ModeloDatosChofer::MdlMostrarDatosChofer($id_adherente);

					foreach ($respuesta as $dato) {
						$adherente[] = $dato;
					}

					if (!empty($respuesta)) {
						return $adherente;
					} else {
						return false;
					}
				}
			}

			public function CtrlExtraerIdAdherente($expediente, $Dc, $Do)
			{
				$adherente = array();
				$respuesta = ModeloDatosChofer::MdlMostrarIdAdherente($expediente, $Dc, $Do);

				foreach ($respuesta as $dato) {
					$adherente[] = $dato;
				}

				if (!empty($respuesta)) {
					return $adherente;
				} else {
					return 'sin adherente';
				}
			}
		}


		class ControladorRequisitos
		{
			static public function CtrMostrarRequisitos($id_tramite, $id_rubro, $id_adherente, $dominio)
			{
				$requi = array();
				$respuesta = ModeloRequisitos::MdlMostrarRequisitos($id_tramite, $id_rubro, $id_adherente, $dominio);

				foreach ($respuesta as $dato) {
					$requi[] = $dato;
				}

				if (!empty($respuesta)) {
					return $requi;
				} else {
					return false;
				}
			}
		}

		class ControladorPeriodos
		{
			static public function CtrMostrarPeriodos($dominio)
			{
				$periodos = array();
				$respuesta = ModeloPeriodos::MdlMostrarPeriodos($dominio);

				foreach ($respuesta as $dato) {
					$periodos[] = $dato;
				}

				if (!empty($respuesta)) {
					return $periodos;
				} else {
					return false;
				}
			}
		}

		class ControladorAgencia
		{
			static public function CtrMostrarAgencia()
			{
				$id_agencia = $_REQUEST['Iag'];
				$arreglo = array();
				$respuesta = ModeloAgencia::MostrarAgencia($id_agencia);

				foreach ($respuesta as $agencias) {
					$arreglo[] = $agencias;
				}
				return $respuesta;
			}
		}

		class ControladorHistorialChoferes
		{
			static public function CtrMostrarHistorialChoferes()
			{
				if (isset($_REQUEST['dominio'])) {
					$dominio = $_REQUEST['dominio'];

					$arreglo = array();
					$respuesta = ModeloHistorialChoferes::MostrarHistorialDominio($dominio);

					foreach ($respuesta as $agencias) {
						$arreglo[] = $agencias;
					}
					return $respuesta;
				}
			}

			static public function CtrMostrarPeriodosDominio()
			{
				if (isset($_REQUEST['Do']) && isset($_POST['Iag'])) {
					$dominio = $_REQUEST['Do'];
					$idAgencia = $_REQUEST['Iag'];

					$arreglo = array();
					$respuesta = ModeloHistorialChoferes::MostrarPeriodosDominio($dominio, $idAgencia);

					if (empty($respuesta)) {
						return "vacio";
					} else {
						foreach ($respuesta as $req) {
							$arreglo[] = $req;
						}
						return $arreglo;
					}
				}
			}

			static public function CtrlHistoDominio()
			{
				if (isset($_REQUEST['dominio'])) {
					$dominio = $_REQUEST['dominio'];

					$arreglo = array();
					$respuesta = ModeloHistorialChoferes::MdlHistoDominio($dominio);

					if (empty($respuesta)) {
						return "vacio";
					} else {
						foreach ($respuesta as $dom) {
							$arreglo[] = $dom;
						}
						return $arreglo;
					}
				}
			}
		}

		class ControladorFiltrarRequisitos
		{
			static public function CtrMostrarRequisitosFiltrados()
			{
				if (isset($_REQUEST['Vd']) && isset($_REQUEST['Vh']) && isset($_REQUEST['Do']) && isset($_REQUEST['Ia'])) {
					$Fdesde = $_REQUEST['Vd'];
					$Fhasta = $_REQUEST['Vh'];
					$dominio = $_REQUEST['Do'];
					$id_adherente = $_REQUEST['Ia'];
					$id_tramite = 8;
					$id_rubro = 0;

					$arreglo = array();
					$respuesta = ModeloRequisitosFiltrados::MdlRequisitosFiltrados($id_tramite, $id_rubro, $id_adherente, $dominio, $Fdesde, $Fhasta);

					foreach ($respuesta as $agencias) {
						$arreglo[] = $agencias;
					}
					return $respuesta;
				}
			}

			static public function CtrlFecha()
			{
				if (isset($_REQUEST['Ia']) && isset($_REQUEST['Do'])) {
					$idAdherente = $_REQUEST['Ia'];
					$dominio = $_REQUEST['Do'];

					$arreglo = array();
					$respuesta = ModeloRequisitosFiltrados::GetFechas($idAdherente, $dominio);

					if (empty($respuesta)) {
						return "no";
					} else {
						foreach ($respuesta as $agencias) {
							$arreglo[] = $agencias;
						}
						return $respuesta;
					}
				}
			}
		}
